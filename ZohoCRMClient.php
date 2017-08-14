<?php

namespace CristianPontes\ZohoCRMClient;

use Buzz\Browser;
use Buzz\Client\Curl;
use CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Transport;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

/**
 * Main Class of the ZohoCRMClient library
 * Only use this class directly
 */
class ZohoCRMClient implements LoggerAwareInterface
{
    /** @var string */
    private $module;
    /** @var Transport\Transport */
    protected $transport;
    /** @var LoggerInterface */
    private $logger;

    /**
     * ZohoCRMClient constructor.
     * @param $module
     * @param $authToken
     * @param string $domain
     * @param int $timeout
     */
    public function __construct($module, $authToken, $domain = 'com', $timeout = 5)
    {
        $this->module = $module;

        if ($authToken instanceof Transport\Transport) {
            $this->transport = $authToken;
        } else {
            $curl_client = new Curl();
            $curl_client->setTimeout($timeout);
            $this->transport = new Transport\XmlDataTransportDecorator(
                new Transport\AuthenticationTokenTransportDecorator(
                    $authToken,
                    new Transport\BuzzTransport(
                        new Browser($curl_client),
                        'https://crm.zoho.' . $domain . '/crm/private/xml/'
                    )
                )
            );
        }
    }

    /**
     * Sets a logger instance on the object
     *
     * @param LoggerInterface $logger
     * @return void
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        if ($this->transport instanceof LoggerAwareInterface) {
            $this->transport->setLogger($logger);
        }
    }

    /**
     * Sets the Zoho CRM module, overriding the the actual value
     * @param $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * @return Request\GetRecords
     */
    public function getRecords()
    {
        return new Request\GetRecords($this->request());
    }

    /**
     * @param int|null $id
     * @return Request\GetRecordById
     */
    public function getRecordById($id = null)
    {
        $request = new Request\GetRecordById($this->request());
        if ($id !== null) {
            $request->id($id);
        }
        return $request;
    }

    /**
     * @return Request\InsertRecords
     */
    public function insertRecords()
    {
        return new Request\InsertRecords($this->request());
    }

    /**
     * @return Request\UpdateRecords
     */
    public function updateRecords()
    {
        return new Request\UpdateRecords($this->request());
    }


    /**
     * @return Request\UpdateRelatedRecords
     */
    public function updateRelatedRecords()
    {
        return new Request\UpdateRelatedRecords($this->request());
    }

    /**
     * @return Request\ConvertLead
     */
    public function convertLead()
    {
        return new Request\ConvertLead($this->request());
    }

    /**
     * @return Request\GetFields
     */
    public function getFields()
    {
        return new Request\GetFields($this->request());
    }

    /**
     * @return Request\DeleteRecords
     */
    public function deleteRecords()
    {
        return new Request\DeleteRecords($this->request());
    }

    /**
     * @return Request\UploadFile
     */
    public function uploadFile()
    {
        return new Request\UploadFile($this->request());
    }

    /**
     * @return Request\DeleteFile
     */
    public function deleteFile()
    {
        return new Request\DeleteFile($this->request());
    }

    /**
     * @return Request\DownloadFile
     */
    public function downloadFile()
    {
        return new Request\DownloadFile($this->request());
    }

    /**
     * @return Request\SearchRecords
     */
    public function searchRecords()
    {
        return new Request\SearchRecords($this->request());
    }

    /**
     * @return Request\GetSearchRecordsByPDC
     */
    public function getSearchRecordsByPDC()
    {
        return new Request\GetSearchRecordsByPDC($this->request());
    }

    /**
     * @return Request\GetRelatedRecords
     */
    public function getRelatedRecords()
    {
        return new Request\GetRelatedRecords($this->request());
    }

    /**
     * @return Request\GetDeletedRecordIds
     */
    public function getDeletedRecordIds()
    {
        return new Request\GetDeletedRecordIds($this->request());
    }

    /**
     * @return \CristianPontes\ZohoCRMClient\Transport\TransportRequest
     */
    protected function request()
    {
        $request = new Transport\TransportRequest($this->module);
        $request->setTransport($this->transport);
        return $request;
    }
}
