<?php
namespace CristianPontes\ZohoCRMClient\Request;

use CristianPontes\ZohoCRMClient\Response\MutationResult;

/**
 * DeleteRecords API Call
 *
 * You can use this method to delete the selected record (you must specify unique ID of the record) and move to the recycle bin
 *
 * @see https://www.zoho.com/crm/help/api/deleterecords.html
 */

class DeleteRecords extends AbstractRequest
{
    protected function configureRequest()
    {
        $this->request
            ->setMethod('deleteRecords');
    }

    /**
     * Set the record Id to delete
     *
     * @param $id
     * @return DeleteRecords
     */
    public function id($id) {
        $this->request->setParam('id', $id);
        return $this;
    }

    /**
     * @return MutationResult
     */
    public function request()
    {
        return $this->request
            ->request();
    }
}