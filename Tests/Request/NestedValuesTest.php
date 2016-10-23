<?php
namespace CristianPontes\ZohoCRMClient\Tests\Request;

use CristianPontes\ZohoCRMClient\Transport\MockTransport;
use CristianPontes\ZohoCRMClient\Transport\XmlDataTransportDecorator;

class NestedValuesTest extends \PHPUnit_Framework_TestCase
{

    private $transport;

    private $mockTransport;


    public function testRecords()
    {
        $this->mockTransport->response = file_get_contents(__DIR__ . '/../XML/invoiceResponseSample.xml');

        $this->transport->call(
            'Invoices',
            'getRecords',
            array('xmlData' => array(
                array(
                    'Subject' => 'Test Subject',
                    'CONTACTID' => 423412341234,
                    'Product Details' => array(
                        array(
                            '@type' => 'product',
                            'Product Id' => 314534523452345,
                            'Unit Price' => '4800',
                            'Quantity' => '1.0',
                            'Total' => '4800',
                        ),
                        array(
                            '@type' => 'product',
                            'Product Id' => 314534523452348,
                            'Unit Price' => '4800',
                            'Quantity' => '1.0',
                            'Total' => '4800',
                        ),
                    )
                )
            ))
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/../XML/nestedRecordsTest.xml'),
            $this->mockTransport->paramList['xmlData']
        );
    }

    protected function setUp()
    {
        $this->mockTransport = new MockTransport();
        $this->transport = new XmlDataTransportDecorator($this->mockTransport);
    }
}