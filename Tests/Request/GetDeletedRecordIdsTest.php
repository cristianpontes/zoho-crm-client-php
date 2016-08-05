<?php
namespace CristianPontes\ZohoCRMClient\Tests\Request;

use CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Transport\TransportRequest;

class GetDeletedRecordIdsTest extends \PHPUnit_Framework_TestCase
{
    /** @var TransportRequest */
    private $request;
    /** @var Request\GetDeletedRecordIds */
    private $getDeletedRecordIds;


    public function testFromIndex()
    {
        $this->getDeletedRecordIds->fromIndex(10);

        $this->assertEquals(10, $this->request->getParam('fromIndex'));
    }

    public function testToIndex()
    {
        $this->getDeletedRecordIds->toIndex(-10);

        $this->assertEquals(-10, $this->request->getParam('toIndex'));
    }

    public function testSince()
    {
        $this->getDeletedRecordIds->since(new \DateTime('16-05-1986 13:37:59'));

        $this->assertEquals(
            '1986-05-16 13:37:59',
            $this->request->getParam('lastModifiedTime')
        );
    }

    protected function setUp()
    {
        $this->request = new TransportRequest('SomeModuleName');

        $this->getDeletedRecordIds = new Request\GetDeletedRecordIds($this->request);
    }
}
