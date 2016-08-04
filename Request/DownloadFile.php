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

class DownloadFile extends AbstractRequest
{
    protected function configureRequest()
    {
        $this->request
            ->setMethod('downloadFile');
    }

    /**
     * Set the file id to download
     *
     * @param $id
     * @return DownloadFile
     */
    public function id($id){
        $this->request->setParam('id', $id);
        return $this;
    }

    /**
     * This must be the full path of the file. i.e: /home/path/to/file.extension
     * In this location the file will be saved
     *
     * @param $path
     * @return DownloadFile
     */
    public function setFilePath($path){
        $this->request->setParam('file_path', $path);
        return $this;
    }

    /**
     * @return bool
     */
    public function request()
    {
        return $this->request
            ->request();
    }
}