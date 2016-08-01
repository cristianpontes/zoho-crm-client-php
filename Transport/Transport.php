<?php
namespace CristianPontes\ZohoCRMClient\Transport;

/**
 * Transport used by the Client to facilitate the connection to Zoho
 */
interface Transport
{
    /**
     * @param string $module
     * @param string $method
     * @param array $paramList
     * @return array
     */
    public function call($module, $method, array $paramList);
}