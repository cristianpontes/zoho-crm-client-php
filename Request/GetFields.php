<?php
namespace CristianPontes\ZohoCRMClient\Request;

/**
 * GetFields API Call
 *
 * You can use the getFields method to fetch details of the fields available in a particular module
 *
 * @see https://www.zoho.com/crm/help/api/getfields.html
 */
class GetFields extends AbstractRequest
{
    protected function configureRequest()
    {
        $this->request->setMethod('getFields');
    }
}
