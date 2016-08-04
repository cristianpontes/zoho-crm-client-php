<?php
namespace CristianPontes\ZohoCRMClient\Tests\Request;

use CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Transport\TransportRequest;

class DownloadFileTest extends \PHPUnit_Framework_TestCase
{
    /** @var TransportRequest */
    private $request;
    /** @var Request\DownloadFile */
    private $downloadFile;

    public function testInitial()
    {
        $this->assertEquals('downloadFile', $this->request->getMethod());
    }

    public function testId()
    {
        $this->downloadFile->id('123');
        $this->assertEquals('123', $this->request->getParam('id'));
    }

    public function testFilePath()
    {
        $file_path = __DIR__."/test.pdf";
        $this->downloadFile->setFilePath($file_path);
        $this->assertEquals($file_path, $this->request->getParam('file_path'));
    }

    protected function setUp()
    {
        $this->request = new TransportRequest('Leads');
        $this->downloadFile = new Request\DownloadFile($this->request);
    }
}