<?php
namespace CristianPontes\ZohoCRMClient\Tests;

use CristianPontes\ZohoCRMClient\Request\GetRecords;
use CristianPontes\ZohoCRMClient\Transport\MockLoggerAwareTransport;
use CristianPontes\ZohoCRMClient\ZohoCRMClient;
use CristianPontes\ZohoCRMClient\Tests\SingleMessageLogger;

class ZohoCRMClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var MockLoggerAwareTransport */
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

    public function testDeleteRecords()
    {
        $request = $this->client->deleteRecords();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\DeleteRecords', $request);
    }

    public function testUploadFile()
    {
        $request = $this->client->uploadFile();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\UploadFile', $request);
    }

    public function testRequest()
    {
        $request = $this->client->publicRequest();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Transport\TransportRequest', $request);
    }

    public function testSetLogger()
    {
        $logger = new SingleMessageLogger();
        $this->client->setLogger($logger);

        $this->client->getRecords()->request();

        $logs = $logger->getLogs();
        $this->assertEquals('Leads/getRecords', $logs);
    }

    protected function setUp()
    {
        $this->transport = new MockLoggerAwareTransport();
        $this->client = new mockZohoCRMClient('Leads', $this->transport);
    }
}

class mockZohoCRMClient extends ZohoCRMClient {
    public function publicRequest()
    {
        return $this->request();
    }
}
