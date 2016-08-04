<?php
namespace CristianPontes\ZohoCRMClient\Tests\Request;

use CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Transport\TransportRequest;

class GetRelatedRecordsTest extends \PHPUnit_Framework_TestCase
{
    /** @var TransportRequest */
    private $request;
    /** @var Request\GetRelatedRecords */
    private $getRelatedRecords;

    public function testFromIndex()
    {
        $this->getRelatedRecords->fromIndex(10);

        $this->assertEquals(10, $this->request->getParam('fromIndex'));
    }

    public function testToIndex()
    {
        $this->getRelatedRecords->toIndex(-10);

        $this->assertEquals(-10, $this->request->getParam('toIndex'));
    }

    public function testWithEmptyFields()
    {
        $this->getRelatedRecords->withEmptyFields();
        $this->assertEquals(
            '2',
            $this->request->getParam('newFormat')
        );
    }

    public function testId()
    {
        $this->getRelatedRecords->id('123');
        $this->assertEquals('123', $this->request->getParam('id'));
    }

    public function testParentModule()
    {
        $this->getRelatedRecords->parentModule('SomeModule');
        $this->assertEquals('SomeModule', $this->request->getParam('parentModule'));
    }

    protected function setUp()
    {
        $this->request = new TransportRequest('SomeModuleName');
        $this->getRelatedRecords = new Request\GetRelatedRecords($this->request);
    }
}
