<?php
namespace CristianPontes\ZohoCRMClient\Transport;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class MockLoggerAwareTransport extends MockTransport implements LoggerAwareInterface
{
    /**
     * @var LoggerInterface logger
     */
    private $logger;

    public function __construct()
    {
        $this->logger = new NullLogger();
    }

    /**
     * Sets a logger instance on the object
     *
     * @param LoggerInterface $logger
     * @return null
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function call($module, $method, array $paramList)
    {
        $this->logger->info(sprintf('%s/%s', $module, $method));

        return parent::call($module, $method, $paramList);
    }


} 