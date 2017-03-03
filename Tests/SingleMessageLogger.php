<?php
namespace CristianPontes\ZohoCRMClient\Tests;

use Psr\Log\AbstractLogger;

class SingleMessageLogger extends AbstractLogger {

    private $message = '';

    public function log($level, $message, array $context = array())
    {
        $this->message = $message;
    }

    public function getLogs()
    {
        return $this->message;
    }
}
