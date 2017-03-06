<?php
namespace CristianPontes\ZohoCRMClient\Tests\Transport;

use CristianPontes\ZohoCRMClient\Transport\MockLoggerAwareTransport;
use CristianPontes\ZohoCRMClient\Tests\SingleMessageLogger;
use CristianPontes\ZohoCRMClient\Transport\AbstractTransportDecorator;

class AbstractTransportDecoratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var mockDecorator */
    private $decorator;

    public function testSetLogger()
    {
        $logger = new SingleMessageLogger();
        $this->decorator->setLogger($logger);

        $module = 'Accounts';
        $method = 'getFields';
        $paramList = array();

        $this->decorator->call($module, $method, $paramList);

        $logs = $logger->getLogs();
        $this->assertEquals('Accounts/getFields', $logs);
    }

    protected function setUp()
    {
        $transport = new MockLoggerAwareTransport();
        $this->decorator = new mockDecorator($transport);
    }
}

class mockDecorator extends AbstractTransportDecorator
{
    public function call($module, $method, array $paramList)
    {
        return $this->transport->call($module, $method, $paramList);
    }
}
