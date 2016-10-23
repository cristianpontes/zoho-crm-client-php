<?php
namespace CristianPontes\ZohoCRMClient\Tests\Request;

use Buzz\Message\Form\FormUpload;
use CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Transport\TransportRequest;

class UploadFileTest extends \PHPUnit_Framework_TestCase
{
    /** @var TransportRequest */
    private $request;
    /** @var Request\UploadFile */
    private $uploadFile;

    public function testInitial()
    {
        $this->assertEquals('uploadFile', $this->request->getMethod());
    }

    public function testId()
    {
        $this->uploadFile->id('123');
        $this->assertEquals('123', $this->request->getParam('id'));
    }

    public function testAttachmentLink()
    {
        $this->uploadFile->attachLink('http://google.com');
        $this->assertEquals('http://google.com', $this->request->getParam('attachmentUrl'));
    }

    public function uploadFromPath()
    {
        $this->uploadFile->uploadFromPath(realpath(__DIR__ . '/../XML/getRecordsResponse.xml'));
        $this->assertTrue($this->request->getParam('content') instanceof FormUpload);
    }

    protected function setUp()
    {
        $this->request = new TransportRequest('Leads');
        $this->uploadFile = new Request\UploadFile($this->request);
    }
}