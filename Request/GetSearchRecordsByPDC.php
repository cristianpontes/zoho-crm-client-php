<?php
namespace CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Response\Record;

/**
 * GetRelatedRecords API Call
 *
 * You can use the getRelatedRecords method to fetch related records
 *
 * @see https://www.zoho.com/crm/help/api/getrelatedrecords.html
 */
class GetSearchRecordsByPDC extends AbstractRequest
{

    protected function configureRequest()
    {
        $this->request
            ->setMethod('getSearchRecordsByPDC')
            ->setParam('newFormat', '1')
            ->setParam('selectColumns', 'All');
    }

    /**
     * @param int $index
     * @return GetSearchRecordsByPDC
     */
    public function fromIndex($index)
    {
        $this->request->setParam('fromIndex', (int) $index);
        return $this;
    }

    /**
     * @param int $index
     * @return GetSearchRecordsByPDC
     */
    public function toIndex($index)
    {
        $this->request->setParam('toIndex', (int) $index);
        return $this;
    }

    /**
     * Column names to select i.e, ['Last Name', 'Website', 'Email']
     * When not set defaults to all columns
     *
     * @param array|string $columns
     * @return GetSearchRecordsByPDC
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
     * Include the empty fields in the response.
     *
     * @return GetSearchRecordsByPDC
     */
    public function withEmptyFields()
    {
        $this->request->setParam('newFormat', "2");
        return $this;
    }

    /**
     * Specify the predefined search column
     * @see https://www.zoho.com/crm/help/api/getsearchrecordsbypdc.html#Default_Predefined_Columns
     *
     * @param $column string
     * @return GetSearchRecordsByPDC
     */
    public function searchColumn($column)
    {
        $this->request->setParam('searchColumn', $column);
        return $this;
    }

    /**
     * Specify the value to be searched
     *
     * @param $value string
     * @return GetSearchRecordsByPDC
     */
    public function searchValue($value)
    {
        $this->request->setParam('searchValue', $value);
        return $this;
    }

    /**
     * @return Record[]
     */
    public function request()
    {
        return $this->request
            ->request();
    }
}
