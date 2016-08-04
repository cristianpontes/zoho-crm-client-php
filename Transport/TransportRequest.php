<?php
namespace CristianPontes\ZohoCRMClient\Transport;
use CristianPontes\ZohoCRMClient\Response\MutationResult;

/**
 * Model representing the request to Zoho without the sugar
 */
class TransportRequest
{
    /** @var Transport */
    private $transport;
    /** @var string */
    private $module;
    /** @var string */
    private $method;
    /** @var array */
    private $paramList;

    /**
     * @param string $module
     */
    public function __construct($module)
    {
        $this->module = $module;
        $this->paramList = array();
    }

    /**
     * @param Transport $transport
     * @return TransportRequest self
     */
    public function setTransport(Transport $transport)
    {
        $this->transport = $transport;
        return $this;
    }

    /**
     * @return Transport
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * @param string $method
     * @return TransportRequest
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return TransportRequest
     */
    public function setParam($key, $value)
    {
        if ($value === null) {
            unset($this->paramList[$key]);
        } else {
            $this->paramList[$key] = $value;
        }
        return $this;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getParam($key)
    {
        return array_key_exists($key, $this->paramList) ? $this->paramList[$key] : null;
    }

    /**
     * @return array|MutationResult|bool
     */
    public function request()
    {
        return $this->transport->call(
            $this->module,
            $this->method,
            $this->paramList
        );
    }

    /**
     * @param string $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }
}
