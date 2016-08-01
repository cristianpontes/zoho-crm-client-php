<?php
namespace CristianPontes\ZohoCRMClient\Request;

/**
 * GetFields API Call
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
