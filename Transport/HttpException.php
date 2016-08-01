<?php
namespace CristianPontes\ZohoCRMClient\Transport;

use CristianPontes\ZohoCRMClient\Exception\Exception;

/**
 * HttpException thrown when Zoho returns a non 200 status code
 */
class HttpException extends Exception
{
    /** @var int */
    private $statusCode;
    /** @var string */
    private $content;

    public function __construct($content, $statusCode)
    {
        $this->statusCode = $statusCode;
        $this->content = $content;
        parent::__construct('Unexpected HTTP response with statuscode: ' . $statusCode);
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}