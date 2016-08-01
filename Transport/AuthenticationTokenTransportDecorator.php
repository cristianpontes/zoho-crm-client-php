<?php
namespace CristianPontes\ZohoCRMClient\Transport;

/**
 * Transport Decorator that transparently adds the authtoken param and scope param
 */
class AuthenticationTokenTransportDecorator implements Transport
{
    private $authToken;
    private $transport;

    function __construct($authToken, Transport $transport)
    {
        $this->authToken = $authToken;
        $this->transport = $transport;
    }

    public function call($module, $method, array $paramList)
    {
        $paramList['authtoken'] = $this->authToken;
        $paramList['scope'] = 'crmapi';

        return $this->transport->call($module, $method, $paramList);
    }
}