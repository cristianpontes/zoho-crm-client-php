<?php
namespace CristianPontes\ZohoCRMClient\Request;

use CristianPontes\ZohoCRMClient\Response\MutationResult;

/**
 * DeleteRecords API Call
 *
 * You can use the deleteRecords method to delete an specific record using the ID
 *
 * @see https://www.zoho.com/crm/help/api/deletefile.html
 */

class DeleteFile extends AbstractRequest
{
    protected function configureRequest()
    {
        $this->request
            ->setMethod('deleteFile');
    }

    /**
     * Set the record Id to delete
     *
     * @param $id
     * @return DeleteFile
     */
    public function id($id){
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