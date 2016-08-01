<?php
namespace CristianPontes\ZohoCRMClient\Tests\Request;

use CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Transport\TransportRequest;

class GetFieldsTest extends \PHPUnit_Framework_TestCase
{
    /** @var TransportRequest */
    private $request;
    /** @var Request\GetFields */
    private $getFields;

    public function testInitial()
    {
        $this->assertEquals('getFields', $this->request->getMethod());
    }

    protected function setUp()
    {
        $this->request = new TransportRequest('Leads');
        $this->getFields = new Request\GetFields($this->request);
    }
}