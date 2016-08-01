<?php
namespace CristianPontes\ZohoCRMClient\Tests;

use CristianPontes\ZohoCRMClient\Request\GetRecords;
use CristianPontes\ZohoCRMClient\Transport\MockTransport;
use CristianPontes\ZohoCRMClient\ZohoCRMClient;

class ZohoCRMClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var MockTransport */
    private $transport;

    /** @var mockZohoCRMClient */
    private $client;

    public function testGetRecords()
    {
        $request = $this->client->getRecords()
            ->selectColumns('id', 'name')
            ->fromIndex(100)
            ->toIndex(200)
            ->sortBy('name')
            ->sortAsc()
            ->since(date_create('now'));

        $this->assertTrue($request instanceof GetRecords);
    }

    public function testGetRecordById()
    {
        $request = $this->client->getRecordById();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\GetRecordById', $request);
    }

    public function testInsertRecords()
    {
        $request = $this->client->insertRecords();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\InsertRecords', $request);
    }

    public function testUpdateRecords()
    {
        $request = $this->client->updateRecords();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\UpdateRecords', $request);
    }

    public function testGetFields()
    {
        $request = $this->client->getFields();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\GetFields', $request);
    }

    public function testRequest()
    {
        $request = $this->client->publicRequest();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Transport\TransportRequest', $request);
    }

    protected function setUp()
    {
        $this->transport = new MockTransport();
        $this->client = new mockZohoCRMClient('Leads', $this->transport);
    }
}

class mockZohoCRMClient extends ZohoCRMClient {
    public function publicRequest()
    {
        return $this->request();
    }
}