<?php
namespace CristianPontes\ZohoCRMClient\Request;

use CristianPontes\ZohoCRMClient\Response\MutationResult;

/**
 * DeleteRecords API Call
 *
 * You can use the deleteRecords method to delete an specific record using the ID
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
     * Set rhe record Id to delete
     *
     * @param $id
     * @return DeleteRecords
     */
    public function id($id){
        $this->request->setParam('id', $id);
        return $this;
    }

    /**
     * @return MutationResult[]
     */
    public function request()
    {
        return $this->request
            ->request();
    }
}