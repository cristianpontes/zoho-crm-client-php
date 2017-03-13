<?php
namespace CristianPontes\ZohoCRMClient\Tests\Request;

use CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Transport\TransportRequest;

class GetSearchRecordsByPDCTest extends \PHPUnit_Framework_TestCase
{
    /** @var TransportRequest */
    private $request;
    /** @var Request\GetSearchRecordsByPDC */
    private $getSearchRecordsByPDC;

    public function testFromIndex()
    {
        $this->getSearchRecordsByPDC->fromIndex(10);

        $this->assertEquals(10, $this->request->getParam('fromIndex'));
    }

    public function testToIndex()
    {
        $this->getSearchRecordsByPDC->toIndex(-10);

        $this->assertEquals(-10, $this->request->getParam('toIndex'));
    }

    public function testWithEmptyFields()
    {
        $this->getSearchRecordsByPDC->withEmptyFields();
        $this->assertEquals(
            '2',
            $this->request->getParam('newFormat')
        );
    }

    public function testSelectColumns()
    {
        $key = 'selectColumns';

        $this->assertEquals('All', $this->request->getParam($key));

        $this->getSearchRecordsByPDC->selectColumns('Last Name', 'Email');

        $this->assertEquals('SomeModuleName(Last Name,Email)', $this->request->getParam($key));
    }

    public function testSearchValue()
    {
        $this->getSearchRecordsByPDC->searchValue('123');
        $this->assertEquals('123', $this->request->getParam('searchValue'));
    }

    public function testSearchColumn()
    {
        $this->getSearchRecordsByPDC->searchColumn('SomeColumn');
        $this->assertEquals('SomeColumn', $this->request->getParam('searchColumn'));
    }

    protected function setUp()
    {
        $this->request = new TransportRequest('SomeModuleName');
        $this->getSearchRecordsByPDC = new Request\GetSearchRecordsByPDC($this->request);
    }
}
