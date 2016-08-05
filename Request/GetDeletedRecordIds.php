<?php
namespace CristianPontes\ZohoCRMClient\Request;

use CristianPontes\ZohoCRMClient\Response\Record;

/**
 * GetDeletedRecordIds API Call
 *
 * You can use the getDeletedRecordIds method to retrieve the list of IDs of deleted records from recycle bin
 *
 * @see https://www.zoho.com/crm/help/api/getdeletedrecordids.html
 */

class GetDeletedRecordIds extends AbstractRequest
{
    protected function configureRequest()
    {
        $this->request
            ->setMethod('getDeletedRecordIds');
    }

    /**
     * @param int $index
     * @return GetDeletedRecordIds
     */
    public function fromIndex($index)
    {
        $this->request->setParam('fromIndex', (int) $index);
        return $this;
    }

    /**
     * @param int $index
     * @return GetDeletedRecordIds
     */
    public function toIndex($index)
    {
        $this->request->setParam('toIndex', (int) $index);
        return $this;
    }

    /**
     * If you specify the time, modified data will be fetched after the configured time.
     *
     * @param \DateTime $timestamp
     * @return GetDeletedRecordIds
     */
    public function since(\DateTime $timestamp)
    {
        $this->request->setParam('lastModifiedTime', $timestamp->format('Y-m-d H:i:s'));
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