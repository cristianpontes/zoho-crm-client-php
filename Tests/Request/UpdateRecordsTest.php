<?php
namespace CristianPontes\ZohoCRMClient\Tests\Request;

use CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Transport\MockTransport;
use CristianPontes\ZohoCRMClient\Transport\TransportRequest;

class UpdateRecordsTest extends \PHPUnit_Framework_TestCase
{
    /** @var MockTransport */
    private $transport;

    /** @var TransportRequest */
    private $request;

    /** @var Request\UpdateRecords */
    private $updateRecords;

    protected function setUp()
    {
        $this->transport = new MockTransport();
        $this->request = new TransportRequest('Leads');
        $this->request->setTransport($this->transport);
        $this->updateRecords = new Request\UpdateRecords($this->request);
    }

    public function testInitial()
    {
        $this->assertEquals('updateRecords', $this->request->getMethod());
        $this->assertEquals(
            4,
            $this->request->getParam('version')
        );
    }

    public function testSingleRecord()
    {
        $this->updateRecords->addRecord(array('abc123'));

        $this->transport->response = true;

        $this->assertTrue($this->updateRecords->request());
        $this->assertEquals(array('version' => 4, 'xmlData' =>  array(array('abc123'))), $this->transport->paramList);
    }

    public function testMultipleRecords()
    {
        $this->updateRecords->addRecord(array('abc123'));
        $this->updateRecords->addRecord(array('abc123'));

        $this->transport->response = true;

        $this->assertTrue($this->updateRecords->request());
        $this->assertEquals(array('version' => 4, 'xmlData' =>  array(array('abc123'), array('abc123'))), $this->transport->paramList);
    }

    public function testTriggerWorkflow()
    {
        $this->updateRecords->triggerWorkflow();
        $this->assertEquals(
            'true',
            $this->request->getParam('wfTrigger')
        );
    }

    public function testOnDuplicateUpdate()
    {
        $this->updateRecords->onDuplicateUpdate();
        $this->assertEquals(
            2,
            $this->request->getParam('duplicateCheck')
        );
    }

    public function testOnDuplicateError()
    {
        $this->updateRecords->onDuplicateError();
        $this->assertEquals(
            1,
            $this->request->getParam('duplicateCheck')
        );
    }

    public function testRequireApproval()
    {
        $this->updateRecords->requireApproval();
        $this->assertEquals(
            'true',
            $this->request->getParam('isApproval')
        );
    }
}
