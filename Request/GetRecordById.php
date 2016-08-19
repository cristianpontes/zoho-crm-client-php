<?php
namespace CristianPontes\ZohoCRMClient\Request;

/**
 * GetRecordById API Call
 *
 * You can use this method to retrieve individual records by record ID
 *
 * @see https://www.zoho.com/crm/help/api/getrecordbyid.html
 */
class GetRecordById  extends AbstractRequest
{
    protected function configureRequest()
    {
        $this->request
            ->setMethod('getRecordById')
            ->setParam('selectColumns', 'All');
    }

    /**
     * Column names to select i.e, ['Last Name', 'Website', 'Email']
     * When not set defaults to all columns
     *
     * @param array $columns
     * @return GetRecordById
     */
    public function selectColumns($columns)
    {
        if (!is_array($columns)) {
            $columns = func_get_args();
        }
        $this->request->setParam(
            'selectColumns',
            $this->request->getModule() . '(' . implode(',', $columns) . ')'
        );
        return $this;
    }

    /**
     * @param string $id
     * @return GetRecordById
     */
    public function id($id)
    {
        $this->request->setParam('id', $id);

        return $this;
    }

    /**
     * Include the empty fields in the response.
     *
     * @return GetRecordById
     */
    public function withEmptyFields()
    {
        $this->request->setParam('newFormat', "2");
        return $this;
    }
}
