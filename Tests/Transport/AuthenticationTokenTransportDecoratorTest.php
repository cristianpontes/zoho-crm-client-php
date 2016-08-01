<?php
namespace CristianPontes\ZohoCRMClient\Tests\Transport;

use CristianPontes\ZohoCRMClient\Transport\AuthenticationTokenTransportDecorator;
use CristianPontes\ZohoCRMClient\Transport\MockTransport;

class AuthenticationTokenTransportDecoratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    private $authToken;
    /** @var MockTransport */
    private $transport;
    /** @var AuthenticationTokenTransportDecorator */
    private $decorator;

    public function testDoesDecorate()
    {
        $module = 'Leads';
        $method = 'getRecords';
        $paramList = array();

        $this->transport->response = 'test 123';

        $this->assertEquals(
            'test 123',
            $this->decorator->call($module, $method, $paramList)
        );

        $this->assertEquals($module, $this->transport->module);
        $this->assertEquals($method, $this->transport->method);

        $this->assertEquals(
            array('authtoken' => $this->authToken, 'scope' => 'crmapi'),
            $this->transport->paramList
        );
    }

    protected function setUp()
    {
        $this->transport = new MockTransport();
        $this->decorator = new AuthenticationTokenTransportDecorator(
            $this->authToken, $this->transport
        );
    }
}