<?php
namespace CristianPontes\ZohoCRMClient\Request;

use CristianPontes\ZohoCRMClient\Response\MutationResult;

/**
 * UpdateRecords API Call
 *
 * You can use the updateRecords method to update or modify the records in Zoho CRM
 *
 * @see https://www.zoho.com/crm/help/api/updaterecords.html
 */
class UpdateRecords extends AbstractRequest
{
    /** @var array */
    private $records = array();

    protected function configureRequest()
    {
        $this->request
            ->setMethod('updateRecords')
            ->setParam('version', 4);
    }

    /**
     * @param array $record Record as a simple associative array
     * @return UpdateRecords
     */
    public function addRecord(array $record)
    {
        $this->records[] = $record;
        return $this;
    }

    /**
     * @return array
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * @param array $records array containing records otherwise added by addRecord()
     * @return UpdateRecords
     */
    public function setRecords(array $records)
    {
        $this->records = $records;
        return $this;
    }

    /**
     * The workflow rules are only triggered for API V2.
     * The API version will be changed automatically to this version
     * When the request has only 1 record.
     * @see https://www.zoho.eu/crm/help/api/insertrecords.html#Insert_Multiple_records (Notes section)
     * @return UpdateRecords
     */
    public function triggerWorkflow()
    {
        $this->request->setParam('wfTrigger', 'true');
        return $this;
    }

    /**
     * @return UpdateRecords
     */
    public function onDuplicateUpdate()
    {
        $this->request->setParam('duplicateCheck', 2);
        return $this;
    }

    /**
     * @return UpdateRecords
     */
    public function onDuplicateError()
    {
        $this->request->setParam('duplicateCheck', 1);
        return $this;
    }

    /**
     * @return UpdateRecords
     */
    public function requireApproval()
    {
        $this->request->setParam('isApproval', 'true');
        return $this;
    }

    /**
     * @return MutationResult[]
     */
    public function request()
    {
        //@TODO: parsing for V2
//        if(count($this->records) < 2) {
//            $this->request->setParam('version', 2);
//        }

        return $this->request
            ->setParam('xmlData', $this->records)
            ->request();
    }
}
