<?php
namespace CristianPontes\ZohoCRMClient\Tests\Request;

use CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Transport\TransportRequest;

class DeleteRecordsTest extends \PHPUnit_Framework_TestCase
{
    /** @var TransportRequest */
    private $request;
    /** @var Request\DeleteRecords */
    private $deleteRecords;

    public function testInitial()
    {
        $this->assertEquals('deleteRecords', $this->request->getMethod());
    }

    public function testId()
    {
        $this->deleteRecords->id('123');
        $this->assertEquals('123', $this->request->getParam('id'));
    }

    protected function setUp()
    {
        $this->request = new TransportRequest('Leads');
        $this->deleteRecords = new Request\DeleteRecords($this->request);
    }
}