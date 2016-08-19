<?php
namespace CristianPontes\ZohoCRMClient\Tests\Request;

use CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Transport\TransportRequest;

class GetRecordByIdTest extends \PHPUnit_Framework_TestCase
{
    /** @var TransportRequest */
    private $request;
    /** @var Request\GetRecordById */
    private $getRecordById;

    public function testInitial()
    {
        $this->assertEquals('getRecordById', $this->request->getMethod());
        $this->assertEquals(
            'All',
            $this->request->getParam('selectColumns')
        );
    }

    public function testSelectColumns()
    {
        $this->getRecordById->selectColumns(array('test'));
        $this->assertEquals(
            'MyOwnModuleName(test)',
            $this->request->getParam('selectColumns')

        );

        $this->getRecordById->selectColumns(array('test', 'test2', 'test4'));
        $this->assertEquals(
            'MyOwnModuleName(test,test2,test4)',
            $this->request->getParam('selectColumns')
        );
    }

    public function testId()
    {
        $this->getRecordById->id('abc123');
        $this->assertEquals(
            'abc123',
            $this->request->getParam('id')
        );
    }

    public function testWithEmptyFields()
    {
        $this->getRecordById->withEmptyFields();
        $this->assertEquals(
            '2',
            $this->request->getParam('newFormat')
        );
    }

    protected function setUp()
    {
        $this->request = new TransportRequest('MyOwnModuleName');
        $this->setGetRecordById(new Request\GetRecordById($this->request));
    }

    /**
     * @param \CristianPontes\ZohoCRMClient\Request\GetRecordById $getRecordById
     */
    public function setGetRecordById( $getRecordById )
    {
        $this->getRecordById = $getRecordById;
    }

    /**
     * @return \CristianPontes\ZohoCRMClient\Request\GetRecordById
     */
    public function getGetRecordById()
    {
        return $this->getRecordById;
    }
}
