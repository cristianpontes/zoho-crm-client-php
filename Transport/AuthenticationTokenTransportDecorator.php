<?php
namespace CristianPontes\ZohoCRMClient\Transport;

/**
 * Transport Decorator that transparently adds the authtoken param and scope param
 */
class AuthenticationTokenTransportDecorator extends AbstractTransportDecorator
{
    private $authToken;

    function __construct($authToken, Transport $transport)
    {
        $this->authToken = $authToken;
        parent::__construct($transport);
    }

    public function call($module, $method, array $paramList)
    {
        $paramList['authtoken'] = $this->authToken;
        $paramList['scope'] = 'crmapi';

        return $this->transport->call($module, $method, $paramList);
    }
}