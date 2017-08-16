<?php
namespace CristianPontes\ZohoCRMClient\Tests\Request;

use CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Transport\MockTransport;
use CristianPontes\ZohoCRMClient\Transport\TransportRequest;

class InsertRecordsTest extends \PHPUnit_Framework_TestCase
{
    /** @var MockTransport */
    private $transport;
    /** @var TransportRequest */
    private $request;
    /** @var Request\InsertRecords */
    private $insertRecords;

    public function testInitialStatus()
    {
        $this->assertEquals('insertRecords', $this->request->getMethod());
        $this->assertEquals(4, $this->request->getParam('version'));
    }

    public function testSingleRecord()
    {
        $record = array('First Name' => 'Cristian', 'Last Name' => 'Pontes');
        $this->insertRecords->addRecord($record);

        $this->transport->response = true;

        $this->assertTrue($this->insertRecords->request());

        $this->assertEquals(array('version' => 4, 'xmlData' => array($record)), $this->transport->paramList);
    }

    public function testMultipleRecords()
    {
        $record = array('First Name' => 'Cristian', 'Last Name' => 'Pontes');
        $this->insertRecords->addRecord($record);
        $this->insertRecords->addRecord($record);

        $this->transport->response = true;

        $this->assertTrue($this->insertRecords->request());

        $this->assertEquals(array('version' => 4, 'xmlData' => array($record, $record)), $this->transport->paramList);
    }

    public function testTriggerWorkflow()
    {
        $this->insertRecords->triggerWorkflow();

        $this->assertEquals('true', $this->request->getParam('wfTrigger'));
    }

    public function testTriggerAssignmentRule()
    {
        $ruleId = 99001321231213;
        $this->insertRecords->triggerAssignmentRule($ruleId);
        $this->assertEquals($ruleId, $this->request->getParam('larid'));
    }

    public function testOnDuplicate()
    {
        $this->insertRecords->onDuplicateUpdate();
        $this->assertEquals(2, $this->request->getParam('duplicateCheck'));

        $this->insertRecords->onDuplicateError();
        $this->assertEquals(1, $this->request->getParam('duplicateCheck'));
    }

    public function testRequireApproval()
    {
        $this->insertRecords->requireApproval();

        $this->assertEquals('true', $this->request->getParam('isApproval'));
    }

    protected function setUp()
    {
        $this->request = new TransportRequest('Leads');
        $this->transport = new MockTransport();
        $this->request->setTransport($this->transport);

        $this->insertRecords = new Request\InsertRecords($this->request);
    }
}
