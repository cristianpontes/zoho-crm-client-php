<?php
namespace CristianPontes\ZohoCRMClient\Tests\Transport;

use CristianPontes\ZohoCRMClient\Transport\BuzzTransport;

class BuzzTransportTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    private $baseUrl;
    /** @var \Buzz\Browser|\PHPUnit_Framework_MockObject_MockObject */
    private $browser;
    /** @var BuzzTransport */
    private $transport;

    public function testCall()
    {
        $response = $this->getMock('\Buzz\Message\Response');
        $response->expects($this->any())
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        $expectedResponse = file_get_contents(
            __DIR__ . '/../XML/getRecordsResponse.xml'
        );
        $response->expects($this->any())
            ->method('getContent')
            ->will($this->returnValue(
                    $expectedResponse
                ));

        $this->browser->expects($this->once())
            ->method('post')
            ->will($this->returnValue($response));

        $response = $this->transport->call(
            'Leads',
            'getRecords',
            array('bla' => 1, 'test' => 'Paarden')
        );

        $this->assertEquals($expectedResponse, $response);
    }

    protected function setUp()
    {
        $this->baseUrl = 'https://crm.zoho.com/crm/private/json/Leads/getMyRecords';
        $this->browser = $this->getMockBuilder('\Buzz\Browser')->disableOriginalConstructor()->getMock();
        $this->transport = new BuzzTransport($this->browser, $this->baseUrl);
    }
}
