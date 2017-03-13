<?php
namespace CristianPontes\ZohoCRMClient\Request;

/**
 * GetRecords API Call
 *
 * You can use the getRecords method to fetch all users data specified in the API request
 *
 * @see https://www.zoho.com/crm/help/api/getrecords.html
 */
class GetRecords extends AbstractRequest
{
    protected function configureRequest()
    {
        $this->request
            ->setMethod('getRecords')
            ->setParam('selectColumns', 'All')
            ->setParam('newFormat', '1');
    }

    /**
     * Column names to select i.e, ['Last Name', 'Website', 'Email']
     * When not set defaults to all columns
     *
     * @param array|string $columns
     * @return GetRecords
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
     * @param int $index
     * @return GetRecords
     */
    public function fromIndex($index)
    {
        $this->request->setParam('fromIndex', (int) $index);
        return $this;
    }

    /**
     * @param int $index
     * @return GetRecords
     */
    public function toIndex($index)
    {
        $this->request->setParam('toIndex', (int) $index);
        return $this;
    }

    /**
     * @param string $column
     * @return GetRecords
     */
    public function sortBy($column)
    {
        $this->request->setParam('sortColumnString', (string) $column);
        return $this;
    }

    /**
     * @return GetRecords
     */
    public function sortAsc()
    {
        $this->sortOrder('asc');
        return $this;
    }

    /**
     * @return GetRecords
     */
    public function sortDesc()
    {
        $this->sortOrder('desc');
        return $this;
    }

    /**
     * If you specify the time, modified data will be fetched after the configured time.
     *
     * @param \DateTime $timestamp
     * @return GetRecords
     */
    public function since(\DateTime $timestamp)
    {
        $this->request->setParam('lastModifiedTime', $timestamp->format('Y-m-d H:i:s'));
        return $this;
    }

    /**
     * Include the empty fields in the response.
     *
     * @return GetRecords
     */
    public function withEmptyFields()
    {
        $this->request->setParam('newFormat', "2");
        return $this;
    }

    private function sortOrder($direction)
    {
        $this->request->setParam('sortOrderString', $direction);
    }
}
