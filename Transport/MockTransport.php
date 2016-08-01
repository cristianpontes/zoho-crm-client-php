<?php
namespace CristianPontes\ZohoCRMClient\Transport;

class MockTransport implements Transport
{
    public $module;
    public $method;
    public $paramList;
    public $response;

    public function call($module, $method, array $paramList)
    {
        $this->module = $module;
        $this->method = $method;
        $this->paramList = $paramList;
        return $this->response;
    }
} 