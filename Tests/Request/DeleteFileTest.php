<?php
namespace CristianPontes\ZohoCRMClient\Tests\Request;

use CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Transport\TransportRequest;

class DeleteFileTest extends \PHPUnit_Framework_TestCase
{
    /** @var TransportRequest */
    private $request;
    /** @var Request\DeleteFile */
    private $deleteFile;

    public function testInitial()
    {
        $this->assertEquals('deleteFile', $this->request->getMethod());
    }

    public function testId()
    {
        $this->deleteFile->id('123');
        $this->assertEquals('123', $this->request->getParam('id'));
    }

    protected function setUp()
    {
        $this->request = new TransportRequest('Leads');
        $this->deleteFile = new Request\DeleteFile($this->request);
    }
}