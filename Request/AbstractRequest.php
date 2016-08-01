<?php
namespace CristianPontes\ZohoCRMClient\Request;

use CristianPontes\ZohoCRMClient\Exception\NoDataException;
use CristianPontes\ZohoCRMClient\Exception\UnexpectedValueException;
use CristianPontes\ZohoCRMClient\Response\Record;
use CristianPontes\ZohoCRMClient\Transport\TransportRequest;

abstract class AbstractRequest implements RequestInterface
{
    /** @var TransportRequest */
    protected $request;

    public function __construct(TransportRequest $request)
    {
        $this->request = $request;
        $this->configureRequest();
    }

    /**
     * @throws UnexpectedValueException
     * @return Record[]|Field[]
     */
    public function request()
    {
        try {
            return $this->request->request();
        } catch (NoDataException $e) {
            return array();
        }
    }

    abstract protected function configureRequest();
}
