<?php
namespace CristianPontes\ZohoCRMClient\Tests\Transport;

use CristianPontes\ZohoCRMClient\Response\Record;
use CristianPontes\ZohoCRMClient\Transport\MockTransport;
use CristianPontes\ZohoCRMClient\Transport\XmlDataTransportDecorator;

class XmlDataTransportDecoratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var MockTransport */
    private $mockTransport;
    /** @var XmlDataTransportDecorator */
    private $transport;

    public function testEncodeRecords()
    {
        $records = array(
            array(
                'First Name' => 'Cristian',
                'Last Name' => 'Pontes',
                'Due Date' => date_create('2012-01-01')
            ),
            array('First Name' => 'Stefan'),
        );

        $this->mockTransport->response = file_get_contents(__DIR__ . '/../XML/getRecordsResponse.xml');

        $records = $this->transport->call(
            'Leads',
            'getRecords',
            array('xmlData' => $records)
        );

        $this->assertEquals(
            <<<XML
<?xml version="1.0"?>
<Leads><row no="1"><FL val="First Name">Cristian</FL><FL val="Last Name">Pontes</FL><FL val="Due Date">01/01/2012</FL></row><row no="2"><FL val="First Name">Stefan</FL></row></Leads>

XML
            ,
            $this->mockTransport->paramList['xmlData']
        );

        $this->assertTrue(is_array($records));

        /** @var Record $record */
        $record = $records[1];
        $this->assertTrue($record instanceof Record);

        $this->assertEquals('test', $record->get('Company'));
        $this->assertEquals('Pontes', $record->get('Last Name'));
    }


    protected function setUp()
    {
        $this->mockTransport = new MockTransport();
        $this->transport = new XmlDataTransportDecorator($this->mockTransport);
    }
}
 