<?php
namespace CristianPontes\ZohoCRMClient\Transport;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

/**
 * Base abstract logger-aware Transport Decorator
 */
abstract class AbstractTransportDecorator implements Transport, LoggerAwareInterface
{
    protected $transport;

    function __construct(Transport $transport)
    {
        $this->transport = $transport;
    }

    /**
     * @param string $module
     * @param string $method
     * @param array $paramList
     * @return array
     */
    abstract public function call($module, $method, array $paramList);

    /**
     * Sets a logger instance on the transport
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        if ($this->transport instanceof LoggerAwareInterface) {
            $this->transport->setLogger($logger);
        }
    }
}