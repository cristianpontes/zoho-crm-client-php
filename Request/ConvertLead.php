<?php
namespace CristianPontes\ZohoCRMClient\Request;

use CristianPontes\ZohoCRMClient\Response\MutationResult;

/**
 * ConvertLead API Call
 *
 * You can use this method to convert lead to potential, account and contact.
 * You can also associate the existing contact or account to the converting lead
 * using this method.
 *
 * @see https://www.zoho.com/crm/help/api/convertlead.html
 */
class ConvertLead extends AbstractRequest
{
    /** @var array */
    private $record = array();

    /**
     * Returns option field names
     * @return array
     */
    static public function getOptionFields()
    {
        return array(
            'createPotential',
            'assignTo',
            'notifyLeadOwner',
            'notifyNewEntityOwner',
        );
    }

    protected function configureRequest()
    {
        $this->request
            ->setMethod('convertLead')
            ->setParam('newFormat', '1')
            ->setParam('version', 2);
    }

    /**
     * Specify unique lead ID to convert
     * @param $leadId
     * @return ConvertLead
     */
    public function setLeadId($leadId)
    {
        $this->request->setParam('leadId', $leadId);
        return $this;
    }

    /**
     * @param array $record Record as a simple associative array
     * @return ConvertLead
     */
    public function addRecord(array $record)
    {
        $this->record = array_merge($this->record, $record);
        return $this;
    }

    /**
     * Specify the existing Account to associate the converting lead
     * @param string $accountId
     * @return ConvertLead
     */
    public function setAccountId($accountId)
    {
        $this->record['ACCOUNTID'] = $accountId;
        return $this;
    }

    /**
     * Specify the existing Contact the converting lead should be associated to 
     * @param string $contactId
     * @return ConvertLead
     */
    public function setContactId($contactId)
    {
        $this->record['CONTACTID'] = $contactId;
        return $this;
    }

    /**
     * Specify if Account name will be replaced by the Company name
     * while associating with the existing account
     * @param bool $overwrite
     * @return ConvertLead
     */
    public function setOverwriteAccountName($overwrite)
    {
        $this->record['OVERWRITE'] = $overwrite ? 'true' : 'false';
        return $this;
    }

    /**
     * Specify if Potential should be created
     * @param bool $createPotential
     * @return ConvertLead
     */
    public function setCreatePotential($createPotential)
    {
        $this->request->setParam('createPotential', $createPotential ? 'true' : 'false');
        return $this;
    }

    /**
     * Specify a user the converted Lead should be assign to
     * @param string $assignTo could be SMOWNERID value or user email
     * @return ConvertLead
     */
    public function setAssignTo($assignTo)
    {
        $this->request->setParam('assignTo', $assignTo);
        return $this;
    }

    /**
     * Specify if a Lead owner should be notified
     * @param bool $notifyLeadOwner
     * @return ConvertLead
     */
    public function setNotifyLeadOwner($notifyLeadOwner)
    {
        $this->request->setParam('notifyLeadOwner', $notifyLeadOwner ? 'true' : 'false');
        return $this;
    }

    /**
     * Specify if a new entity owner should be notified
     * @param bool $notifyNewEntityOwner
     * @return ConvertLead
     */
    public function setNotifyNewEntityOwner($notifyNewEntityOwner)
    {
        $this->request->setParam('notifyNewEntityOwner', $notifyNewEntityOwner ? 'true' : 'false');
        return $this;
    }

    /**
     * Include the empty fields in the response.
     *
     * @return ConvertLead
     */
    public function withEmptyFields()
    {
        $this->request->setParam('newFormat', "2");
        return $this;
    }

    /**
     * @return MutationResult[]
     */
    public function request()
    {
        return $this->request
            ->setParam('xmlData', $this->record)
            ->request();
    }
}
