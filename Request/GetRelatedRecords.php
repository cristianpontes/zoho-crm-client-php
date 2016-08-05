<?php
namespace CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Response\Record;

/**
 * GetRelatedRecords API Call
 *
 * You can use the getRelatedRecords method to fetch related records
 *
 * @see https://www.zoho.com/crm/help/api/getrelatedrecords.html
 */
class GetRelatedRecords extends AbstractRequest
{

    protected function configureRequest()
    {
        $this->request
            ->setMethod('getRelatedRecords')
            ->setParam('newFormat', '1');
    }

    /**
     * @param int $index
     * @return GetRelatedRecords
     */
    public function fromIndex($index)
    {
        $this->request->setParam('fromIndex', (int) $index);
        return $this;
    }

    /**
     * @param int $index
     * @return GetRelatedRecords
     */
    public function toIndex($index)
    {
        $this->request->setParam('toIndex', (int) $index);
        return $this;
    }

    /**
     * Include the empty fields in the response.
     *
     * @return GetRelatedRecords
     */
    public function withEmptyFields()
    {
        $this->request->setParam('newFormat', "2");
        return $this;
    }

    /**
     * Module for which you want to fetch the related records
     * i.e: If you want to fetch Leads related to a Campaign, then Campaigns is your parent module.
     *
     * @param $parentModule string
     * @return GetRelatedRecords
     */
    public function parentModule($parentModule)
    {
        $this->request->setParam('parentModule', $parentModule);
        return $this;
    }

    /**
     * The id of the record for which you want to fetch related records
     *
     * @param $id string
     * @return GetRelatedRecords
     */
    public function id($id)
    {
        $this->request->setParam('id', $id);
        return $this;
    }

    /**
     * @return Record[]
     */
    public function request()
    {
        return $this->request
            ->request();
    }
}
