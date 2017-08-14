<?php
namespace CristianPontes\ZohoCRMClient\Tests\Request;

use CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Transport\MockTransport;
use CristianPontes\ZohoCRMClient\Transport\TransportRequest;

class UpdateRelatedRecordsTest extends \PHPUnit_Framework_TestCase
{
    /** @var MockTransport */
    private $transport;

    /** @var TransportRequest */
    private $request;

    /** @var Request\UpdateRelatedRecords */
    private $updateRelatedRecords;

    protected function setUp()
    {
        $this->transport = new MockTransport();
        $this->request = new TransportRequest('Products');
        $this->request->setTransport($this->transport);
        $this->updateRelatedRecords = new Request\UpdateRelatedRecords($this->request);
    }

    public function testInitial()
    {
        $this->assertEquals('updateRelatedRecords', $this->request->getMethod());
        $this->assertEquals(
            4,
            $this->request->getParam('version')
        );
    }

    public function testRecords()
    {
        $record = array(
            'PRODUCTID'     => '508020000000061987',
            'list_price'    => '100.00'
        );

        $this->updateRelatedRecords->addRecord($record);

        $this->transport->response = true;

        $this->assertTrue($this->updateRelatedRecords->request());
        $this->assertEquals(array('version' => 4, 'xmlData' =>  array($record)), $this->transport->paramList);
    }

    public function testRelatedModule()
    {
        $this->updateRelatedRecords->relatedModule('Leads');
        $this->assertEquals(
            'Leads',
            $this->request->getParam('relatedModule')
        );
    }

    public function testId()
    {
        $this->updateRelatedRecords->id('123');
        $this->assertEquals(
            123,
            $this->request->getParam('id')
        );
    }
}
