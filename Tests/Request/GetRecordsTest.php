<?php
namespace CristianPontes\ZohoCRMClient\Tests\Request;

use CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Transport\TransportRequest;

class GetRecordsTest extends \PHPUnit_Framework_TestCase
{
    /** @var TransportRequest */
    private $request;
    /** @var Request\GetRecords */
    private $getRecords;

    public function testSelectColumns()
    {
        $key = 'selectColumns';

        $this->assertEquals('All', $this->request->getParam($key));

        $this->getRecords->selectColumns('Last Name', 'Email');

        $this->assertEquals('SomeModuleName(Last Name,Email)', $this->request->getParam($key));
    }

    public function testFromIndex()
    {
        $this->getRecords->fromIndex(10);

        $this->assertEquals(10, $this->request->getParam('fromIndex'));
    }

    public function testToIndex()
    {
        $this->getRecords->toIndex(-10);

        $this->assertEquals(-10, $this->request->getParam('toIndex'));
    }

    public function testSortBy()
    {
        $this->getRecords->sortBy('Email');

        $this->assertEquals(
            'Email',
            $this->request->getParam('sortColumnString')
        );
    }

    public function testSortOrder()
    {
        $this->getRecords->sortAsc();

        $this->assertEquals(
            'asc',
            $this->request->getParam('sortOrderString')
        );

        $this->getRecords->sortDesc();

        $this->assertEquals(
            'desc',
            $this->request->getParam('sortOrderString')
        );
    }

    public function testSince()
    {
        $this->getRecords->since(new \DateTime('16-05-1986 13:37:59'));

        $this->assertEquals(
            '1986-05-16 13:37:59',
            $this->request->getParam('lastModifiedTime')
        );
    }

    public function testWithEmptyFields()
    {
        $this->getRecords->withEmptyFields();
        $this->assertEquals(
            '2',
            $this->request->getParam('newFormat')
        );
    }

    protected function setUp()
    {
        $this->request = new TransportRequest('SomeModuleName');

        $this->getRecords = new Request\GetRecords($this->request);
    }
}
 