<?php
namespace CristianPontes\ZohoCRMClient\Tests\Request;

use CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Transport\TransportRequest;

class SearchRecordsTest extends \PHPUnit_Framework_TestCase
{
    /** @var TransportRequest */
    private $request;
    /** @var Request\SearchRecords */
    private $searchRecords;

    public function testSelectColumns()
    {
        $key = 'selectColumns';

        $this->assertEquals('All', $this->request->getParam($key));

        $this->searchRecords->selectColumns('Last Name', 'Email');

        $this->assertEquals('SomeModuleName(Last Name,Email)', $this->request->getParam($key));
    }

    public function testFromIndex()
    {
        $this->searchRecords->fromIndex(10);

        $this->assertEquals(10, $this->request->getParam('fromIndex'));
    }

    public function testToIndex()
    {
        $this->searchRecords->toIndex(-10);

        $this->assertEquals(-10, $this->request->getParam('toIndex'));
    }

    public function testWithEmptyFields()
    {
        $this->searchRecords->withEmptyFields();
        $this->assertEquals(
            '2',
            $this->request->getParam('newFormat')
        );
    }

    public function testWhere()
    {
        $this->searchRecords
            ->where('SomeField1', 'SomeValue1')
            ->where('SomeField2', 'SomeValue2');
        $this->assertEquals(
            '(((SomeField1:SomeValue1)AND(SomeField2:SomeValue2)))',
            $this->request->getParam('criteria')
        );
    }

    public function testOrWhere()
    {
        $this->searchRecords
            ->where('SomeField1', 'SomeValue1')
            ->where('SomeField2', 'SomeValue2')
            ->orWhere('SomeField3', 'SomeValue3')
            ->orWhere('SomeField3', 'SomeValue4');
        $this->assertEquals(
            '(((SomeField1:SomeValue1)AND(SomeField2:SomeValue2))OR(SomeField3:SomeValue3)OR(SomeField3:SomeValue4))',
            $this->request->getParam('criteria')
        );
    }

    protected function setUp()
    {
        $this->request = new TransportRequest('SomeModuleName');
        $this->searchRecords = new Request\SearchRecords($this->request);
    }
}
