<?php
namespace CristianPontes\ZohoCRMClient\Transport;

use Buzz\Browser;
use Buzz\Message\Form\FormUpload;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Transport implemented using the Buzz library to do HTTP calls to Zoho
 */
class BuzzTransport implements Transport, LoggerAwareInterface
{
    private $browser;
    private $baseUrl;
    private $logger;

    public function __construct(Browser $browser, $baseUrl)
    {
        $this->browser = $browser;
        $this->baseUrl = $baseUrl;
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
        $url = $this->baseUrl . $module . '/' .  $method;
        $headers = array();
        $requestBody = http_build_query($paramList, '', '&');

        $this->logger->info(sprintf(
                '[cristianpontes/zoho_crm_client_php] request: call "%s" with params %s',
                $module . '/' . $method,
                $requestBody
            ));

        // Checking for multipart request
        $multipart = false;
        foreach ($paramList as $param) {
            if($param instanceof FormUpload){
                $multipart = true;
                break;
            }
        }

        if($multipart){
            /** @var \Buzz\Message\MessageInterface $response */
            $response = $this->browser->submit($url, $paramList, 'POST', $headers);
        }
        else{
            /** @var \Buzz\Message\Response $response */
            $response = $this->browser->post($url, $headers, $requestBody);
        }

        $responseContent = $response->getContent();
        if ($response->getStatusCode() !== 200) {
            $this->logger->error(sprintf(
                    '[cristianpontes/zoho_crm_client_php] fault "%s" for request "%s" with params %s',
                    $responseContent,
                    $module . '/' . $method,
                    $requestBody
                ));
            throw new HttpException(
                $responseContent, $response->getStatusCode()
            );
        }

        $this->logger->info(sprintf(
                '[cristianpontes/zoho_crm_client_php] response: %s',
                $responseContent
            ));

        return $responseContent;
    }
}