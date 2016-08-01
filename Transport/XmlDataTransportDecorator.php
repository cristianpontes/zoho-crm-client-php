<?php
namespace CristianPontes\ZohoCRMClient\Transport;

use CristianPontes\ZohoCRMClient\Exception;
use CristianPontes\ZohoCRMClient\Response;
use CristianPontes\ZohoCRMClient\ZohoError;

use SimpleXMLElement;

/**
 * XmlDataTransportDecorator handles the XML communication with Zoho
 */
class XmlDataTransportDecorator implements Transport
{
    /** @var Transport */
    private $transport;
    /** @var string */
    private $module;
    /** @var string */
    private $method;

    /**
     * @param Transport $transport to be decorated with XML support
     */
    public function __construct(Transport $transport)
    {
        $this->transport = $transport;
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

        if (array_key_exists('xmlData', $paramList)) {
            $paramList['xmlData'] = $this->encodeRecords($paramList['xmlData']);
        }

        $response = $this->transport->call($module, $method, $paramList);

        return $this->parse($response);
    }

    /**
     * @param array $records
     * @throws \CristianPontes\ZohoCRMClient\Exception\RuntimeException
     * @return string XML representation of the records
     */
    private function encodeRecords(array $records)
    {
        $root = new SimpleXMLElement('<'.$this->module.'></'.$this->module.'>');

        foreach ($records as $no => $record) {
            $row = $root->addChild('row');
            $row->addAttribute('no', $no + 1);

            foreach ($record as $key => $value) {
                if ($value instanceof \DateTime) {
                    if ($value->format('His') === '000000') {
                        $value = $value->format('m/d/Y');
                    } else {
                        $value = $value->format('Y-m-d H:i:s');
                    }
                }
                $keyValue = $row->addChild('FL');
                $keyValue[0] = $value;
                $keyValue->addAttribute('val', $key);
            }
        }

        return $root->asXML();
    }

    /**
     * Parses the XML returned by Zoho to the appropriate objects
     *
     * @param string $content Response body as returned by Zoho
     * @throws Exception\UnexpectedValueException When invalid XML is given to parse
     * @throws Exception\NoDataException when Zoho tells us there is no data
     * @throws Exception\ZohoErrorException when content is a Error response
     * @return Response\Record[]|Response\Field[]|Response\MutationResult[]
     */
    private function parse($content)
    {
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

        if (isset($xml->result->{$this->module})) {
            return $this->parseResponseGetRecords($xml);
        }

        if (isset($xml->result->row->success) || isset($xml->result->row->error)) {
            return $this->parseResponsePostRecordsMultiple($xml);
        }

        throw new Exception\UnexpectedValueException('Xml doesn\'t contain expected fields');
    }

    private function parseResponseGetRecords(SimpleXMLElement $xml)
    {
        $records = array();
        foreach ($xml->result->{$this->module}->row as $row) {
            $records[(string) $row['no']] = $this->rowToRecord($row);
        }

        return $records;
    }

    private function rowToRecord(SimpleXMLElement $row)
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

    private function parseResponseDeleteRecords($xml)
    {
        return new Response\MutationResult(1, (string) $xml->result->code);
    }

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
