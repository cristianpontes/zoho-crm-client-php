<?php
namespace CristianPontes\ZohoCRMClient\Tests\Request;

use CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Transport\MockTransport;
use CristianPontes\ZohoCRMClient\Transport\TransportRequest;
use CristianPontes\ZohoCRMClient\Transport\XmlDataTransportDecorator;

class ConvertLeadTest extends \PHPUnit_Framework_TestCase
{
    /** @var MockTransport */
    private $mockTransport;
    /** @var XmlDataTransportDecorator */
    private $transport;
    /** @var TransportRequest */
    private $request;
    /** @var Request\ConvertLead */
    private $convertLead;

    public function testInitialStatus()
    {
        $this->assertEquals('convertLead', $this->request->getMethod());
        $this->assertEquals(2, $this->request->getParam('version'));
        $this->assertEquals('1', $this->request->getParam('newFormat'));
    }

    public function testConvertLead()
    {
        $this->mockTransport->response = file_get_contents(__DIR__ . '/../XML/convertLeadResponseSample.xml');

        $this->convertLead->setCreatePotential(true);
        $this->convertLead->setAssignTo('sample@zoho.com');
        $this->convertLead->setNotifyLeadOwner('true');
        $this->convertLead->setNotifyNewEntityOwner('true');

        $this->convertLead->setAccountId('543212345');
        $this->convertLead->setContactId('1234554321');
        $this->convertLead->setOverwriteAccountName(true);

        $record = array(
            "Potential Name" => 'Samplepotential',
            "Closing Date" => '12/21/2009',
            "Potential Stage" => 'Closed Won',
            "Contact Role" => 'Purchasing',
            "Amount" => '3432.23',
            "Probability" => '100',
        );
        $this->convertLead->addRecord($record);

        $result = $this->convertLead->request();

        $this->assertEquals(
            file_get_contents(__DIR__ . '/../XML/convertLeadTest.xml'),
            $this->mockTransport->paramList['xmlData']
        );

        $expectedResult = array(
            'Account' => '161789000005836001',
            'Contact' => '161789000005836003',
            'Potential' => '161789000005848039',
        );
        $this->assertEquals($expectedResult, $result);
    }

    public function testLeadId()
    {
        $this->convertLead->setLeadId('123456789');
        $this->assertEquals('123456789', $this->request->getParam('leadId'));
    }

    public function testCreatePotential()
    {
        $this->convertLead->setCreatePotential(true);
        $this->assertEquals('true', $this->request->getParam('createPotential'));

        $this->convertLead->setCreatePotential(false);
        $this->assertEquals('false', $this->request->getParam('createPotential'));
    }

    public function testNotify()
    {
        $this->convertLead->setNotifyLeadOwner(true);
        $this->assertEquals('true', $this->request->getParam('notifyLeadOwner'));

        $this->convertLead->setNotifyLeadOwner(false);
        $this->assertEquals('false', $this->request->getParam('notifyLeadOwner'));

        $this->convertLead->setNotifyNewEntityOwner(true);
        $this->assertEquals('true', $this->request->getParam('notifyNewEntityOwner'));

        $this->convertLead->setNotifyNewEntityOwner(false);
        $this->assertEquals('false', $this->request->getParam('notifyNewEntityOwner'));
    }


    protected function setUp()
    {
        $this->request = new TransportRequest('Leads');
        $this->mockTransport = new MockTransport();
        $this->transport = new XmlDataTransportDecorator($this->mockTransport);
        $this->request->setTransport($this->transport);

        $this->convertLead = new Request\ConvertLead($this->request);
    }
}
 