<?php
namespace CristianPontes\ZohoCRMClient\Transport;

use CristianPontes\ZohoCRMClient\Exception;
use CristianPontes\ZohoCRMClient\Request\ConvertLead;
use CristianPontes\ZohoCRMClient\Response;
use CristianPontes\ZohoCRMClient\ZohoError;

use SimpleXMLElement;

/**
 * XmlDataTransportDecorator handles the XML communication with Zoho
 */
class XmlDataTransportDecorator extends AbstractTransportDecorator
{
    /** @var string */
    private $module;
    /** @var string */
    private $method;
    /** @var array */
    private $call_params;


    /**
     * @param Transport $transport to be decorated with XML support
     */
    public function __construct(Transport $transport)
    {
        parent::__construct($transport);
    }

    /**
     * @param string $module
     * @param string $method
     * @param array $paramList
     * @return array
     */
    public function call($module, $method, array $paramList)
    {
        $this->module = $module;
        $this->method = $method;
        $this->call_params = $paramList;

        if ($this->method == 'convertLead') {
            $paramList['xmlData'] = $this->encodeRequestConvertLead($paramList);
        } else {
            if (array_key_exists('xmlData', $paramList)) {
                $paramList['xmlData'] = $this->encodeRecords($paramList['xmlData']);
            }
        }

        $response = $this->transport->call($module, $method, $paramList);

        return $this->parse($response);
    }

    /**
     * 
     * @param array $paramList
     * @return string XML representation of the records
     */
    private function encodeRequestConvertLead(array $paramList)
    {
        $root = new SimpleXMLElement('<Potentials></Potentials>');
        $options = array();

        // row 1 (options)
        foreach (ConvertLead::getOptionFields() as $optionName) {
            if (isset($paramList[$optionName])) {
                $options[$optionName] = $paramList[$optionName];
            }
        }
        $row = $root->addChild('row');
        $row->addAttribute('no', 1);
        $this->encodeRecord($options, 'option', $row);

        // row 2 (data)
        if (array_key_exists('xmlData', $paramList)) {
            $record = $paramList['xmlData'];
            if ($record) {
                $row = $root->addChild('row');
                $row->addAttribute('no', 2);
                $this->encodeRecord($record, 'FL', $row);
            }
        }
        return $root->asXML();
    }

    /**
     * @param array $records
     * @throws \CristianPontes\ZohoCRMClient\Exception\RuntimeException
     * @return string XML representation of the records
     */
    private function encodeRecords(array $records)
    {
        $module = $this->method == 'updateRelatedRecords' ?
                $this->call_params['relatedModule'] : $this->module;

        $root = new SimpleXMLElement('<'.$module.'></'.$module.'>');

        foreach ($records as $no => $record) {
            $row = $root->addChild('row');
            $row->addAttribute('no', $no + 1);

            $this->encodeRecord($record, 'FL', $row);
        }

        return $root->asXML();
    }

    /**
     * Encodes a request record
     * @param array $record
     * @param string $childName XML node name
     * @param SimpleXMLElement $xml
     */
    private function encodeRecord($record, $childName, &$xml)
    {
        foreach ($record as $key => $value)
        {
            if ($value instanceof \DateTime)
            {
                if ($value->format('His') === '000000') {
                    $value = $value->format('m/d/Y');
                } else {
                    $value = $value->format('Y-m-d H:i:s');
                }
            }

            $keyValue = $xml->addChild($childName);
            $keyValue->addAttribute('val', $key);

            if(is_array($value)) {
               $this->parseNestedValues($value, $keyValue);
            }
            else {
                $keyValue[0] = $value;
            }
        }
    }

    /**
     * @param $array
     * @param SimpleXMLElement $xml
     */
    private function parseNestedValues($array, &$xml)
    {
        foreach($array as $key => $value)
        {
            if(is_array($value))
            {
                $type = isset($value['@type']) ? $value['@type'] : "null";
                unset($value['@type']);

                $subNode = $xml->addChild("$type");
                $subNode->addAttribute('no', $key + 1);
                $this->parseNestedValues($value, $subNode);
            }
            else
            {
                $keyValue = $xml->addChild('FL');
                $keyValue[0] = $value;
                $keyValue->addAttribute('val', $key);
            }
        }
    }

    /**
     * Parses the XML returned by Zoho to the appropriate objects
     *
     * @param string $content Response body as returned by Zoho
     * @throws Exception\UnexpectedValueException When invalid XML is given to parse
     * @throws Exception\NoDataException when Zoho tells us there is no data
     * @throws Exception\ZohoErrorException when content is a Error response
     * @return bool|Response\Record|Response\Record[]|Response\Field[]|Response\MutationResult
     */
    private function parse($content)
    {

        if ($this->method == 'downloadFile') {
            return $this->parseResponseDownloadFile($content);
        }

        $xml = new SimpleXMLElement($content);
        if (isset($xml->error)) {
            throw new Exception\ZohoErrorException(
                new ZohoError(
                    (string) $xml->error->code,
                    (string) $xml->error->message
                )
            );
        }

        if (isset($xml->nodata)) {
            throw new Exception\NoDataException(
                new ZohoError(
                    (string)$xml->nodata->code, (string) $xml->nodata->message
                )
            );
        }

        if ($this->method == 'getFields') {
            return $this->parseResponseGetFields($xml);
        }

        if ($this->method == 'deleteRecords') {
            return $this->parseResponseDeleteRecords($xml);
        }

        if ($this->method == 'uploadFile') {
            return $this->parseResponseUploadFile($xml);
        }

        if ($this->method == 'deleteFile') {
            return $this->parseResponseDeleteFile($xml);
        }

        if ($this->method == 'getDeletedRecordIds') {
            return $this->parseResponseGetDeletedRecordIds($xml);
        }

        if ($this->method == 'convertLead') {
            return $this->parseResponseConvertLead($xml);
        }

        if ($this->method == 'updateRelatedRecords') {
            return $this->parseUpdateRelatedRecords($xml);
        }

        if (isset($xml->result->{$this->module})) {
            return $this->parseResponseGetRecords($xml);
        }

        if (isset($xml->result->row->success) || isset($xml->result->row->error)) {
            return $this->parseResponsePostRecordsMultiple($xml);
        }

        throw new Exception\UnexpectedValueException('Xml doesn\'t contain expected fields');
    }

    /**
     * @param SimpleXMLElement $xml
     * @return array
     */
    private function parseResponseGetRecords(SimpleXMLElement $xml)
    {
        $records = array();
        foreach ($xml->result->{$this->module}->row as $row) {
            $records[(string) $row['no']] = $this->rowToRecord($row);
        }

        return $records;
    }

    /**
     * @param SimpleXMLElement $row
     * @return Response\Record
     */
    private function rowToRecord($row)
    {
        $data = array();
        foreach($row as $field) {
            if ($field->count() > 0) {
                foreach ($field->children() as $item) {
                    foreach ($item->children() as $subitem) {
                        $data[(string) $field['val']][(string) $item['no']][(string) $subitem['val']] = (string) $subitem;
                    }
                }
            }
            else {
                $data[(string) $field['val']] = (string) $field;
            }
        }

        return new Response\Record($data, (int) $row['no']);
    }

    /**
     * @param SimpleXMLElement $xml
     * @return array
     */
    private function parseResponseGetFields($xml)
    {
        $records = array();
        foreach ($xml->section as $section) {
            foreach ($section as $field) {
                $options = array();
                if ($field->children()->count() > 0) {
                    $options = array();
                    foreach ($field->children() as $value) {
                        $options[] = (string) $value;
                    }
                }

                $records[] = new Response\Field(
                    (string) $section['name'],
                    (string) $field['label'],
                    (string) $field['type'],
                    (string) $field['req'] === 'true',
                    (string) $field['isreadonly'] === 'true',
                    (int) $field['maxlength'],
                    $options,
                    (string) $field['customfield'] === 'true',
                    (string) isset($field['lm']) ? $field['lm'] : false
                );
            }
        }
        return $records;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return Response\MutationResult
     */
    private function parseResponseDeleteRecords($xml)
    {
        return new Response\MutationResult(1, (string) $xml->result->code);
    }

    /**
     * @param SimpleXMLElement $xml
     * @return Response\MutationResult
     */
    private function parseResponseUploadFile($xml)
    {
        $code = isset($xml->result->recorddetail) ? "4800" : "0";
        $response = new Response\MutationResult(1, $code);
        if($code === "4800")
        {
            $response->setId((string) $xml->result->recorddetail->FL[0]);
            $response->setCreatedTime((string) $xml->result->recorddetail->FL[1]);
            $response->setModifiedTime((string) $xml->result->recorddetail->FL[2]);
        }
        return $response;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return Response\MutationResult
     */
    private function parseResponseDeleteFile($xml)
    {
        return new Response\MutationResult(1, (string) $xml->success->code);
    }

    /**
     * @param $file_content
     * @return bool
     * @throws Exception\Exception
     */
    private function parseResponseDownloadFile($file_content)
    {
        if(!isset($this->call_params['file_path'])) {
            throw new Exception\Exception('Missed file path, set it');
        }

        $fp = fopen($this->call_params['file_path'], 'w');
        $success = fwrite($fp, $file_content);
        fclose($fp);

        return $success ? true : false;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return Response\Record
     */
    private function parseResponseGetDeletedRecordIds($xml)
    {
        $ids = explode(',', (string) $xml->result->DeletedIDs);
        return new Response\Record($ids, 1);
    }

    /**
     * @param SimpleXMLElement $xml
     * @return array
     */
    private function parseResponseConvertLead($xml)
    {
        $records = array();
        foreach ($xml as $row) {
            $records[$row->getName()] = (string) $row;
        }

        return $records;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return Response\Record
     */
    private function parseUpdateRelatedRecords($xml)
    {
        $result  = (array) $xml->result;
        $added   = isset($result['added-ids'])   ? eval('return ' . $result['added-ids'] . ';')   : array();
        $updated = isset($result['updated-ids']) ? eval('return ' . $result['updated-ids'] . ';') : array();
        $data = array(
            'added-ids'   => $added,
            'updated-ids' => $updated
        );
        return new Response\Record($data, 1);
    }


    /**
     * @param $xml
     * @return array
     */
    private function parseResponsePostRecordsMultiple($xml)
    {
        $records = array();
        foreach ($xml->result->row as $row) {
            $no = (string) $row['no'];
            if (isset($row->success)) {
                $success = new Response\MutationResult((int) $no, (string) $row->success->code);
                foreach ($row->success->details->children() as $field) {
                    $method = 'set' . str_replace(' ', '', $field['val']);
                    if (method_exists($success, $method)) {
                        $success->{$method}((string) $field);
                    }
                }
                $records[$no] = $success;
            } else {
                $error = new Response\MutationResult((int) $no, (string) $row->error->code);
                $error->setError(
                    new ZohoError((string) $row->error->code, (string) $row->error->details)
                );
                $records[$no] = $error;
            }
        }

        return $records;
    }
}
