<?php
namespace CristianPontes\ZohoCRMClient\Request;

use CristianPontes\ZohoCRMClient\Response\MutationResult;

/**
 * UpdateRelatedRecords API Call
 *
 * You can use the updateRelatedRecords method to update records related to another record.
 *
 * @see https://www.zoho.eu/crm/help/api/updaterelatedrecords.html
 */
class UpdateRelatedRecords extends AbstractRequest
{
    /** @var array */
    private $records = array();

    /**
     *
     */
    protected function configureRequest()
    {
        $this->request
            ->setMethod('updateRelatedRecords')
            ->setParam('version', 4);
    }

    /**
     * @param array $record Record as a simple associative array
     * @return UpdateRelatedRecords
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
     * @return UpdateRelatedRecords
     */
    public function setRecords(array $records)
    {
        $this->records = $records;
        return $this;
    }

    /**
     * The ID of the record to be updated.
     * @param $id
     * @return UpdateRelatedRecords
     */
    public function id($id)
    {
        $this->request->setParam('id', $id);
        return $this;
    }

    /**
     * The module to which a record is related.
     * i.e: If a lead related to a campaign needs to be updated, the value for this parameter will be Leads.
     * @param $module
     * @return UpdateRelatedRecords
     */
    public function relatedModule($module)
    {
        $this->request->setParam('relatedModule', $module);
        return $this;
    }

    /**
     * @return MutationResult[]
     */
    public function request()
    {
        return $this->request
            ->setParam('xmlData', $this->records)
            ->request();
    }
}
