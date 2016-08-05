<?php
namespace CristianPontes\ZohoCRMClient\Request;

use Buzz\Message\Form\FormUpload;
use CristianPontes\ZohoCRMClient\Response\MutationResult;

/**
 * UploadFile API Call
 *
 * You can use this method to attach files to records
 *
 * @see https://www.zoho.com/crm/help/api/uploadfile.html
 */

class UploadFile extends AbstractRequest
{
    protected function configureRequest()
    {
        $this->request
            ->setMethod('uploadFile');
    }

    /**
     * Set rhe record Id to delete
     *
     * @param $id
     * @return UploadFile
     */
    public function id($id)
    {
        $this->request->setParam('id', $id);
        return $this;
    }


    /**
     * Attach a external link to a record
     *
     * @param $link
     * @return UploadFile
     */
    public function attachLink($link)
    {
        $this->request->setParam('attachmentUrl', $link);
        return $this;
    }


    /**
     * Pass the file input stream to a record
     *
     * @param $path - this must be the full path of the file. i.e: /home/path/to/file.extension
     * @return UploadFile
     */
    public function uploadFromPath($path)
    {
        $file = new FormUpload($path);
        $this->request->setParam('content', $file);
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