<?php
namespace CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Response\Record;

/**
 * SearchRecords API Call
 *
 * You can use the searchRecords method to get the list of records that meet your search criteria
 *
 * @see https://www.zoho.com/crm/help/api/searchrecords.html
 */
class SearchRecords extends AbstractRequest
{
    private $wheres = array();
    private $orWheres = array();

    protected function configureRequest()
    {
        $this->request
            ->setMethod('searchRecords')
            ->setParam('selectColumns', 'All')
            ->setParam('newFormat', '1');
    }

    /**
     * Column names to select i.e, ['Last Name', 'Website', 'Email']
     * When not set defaults to all columns
     *
     * @param array $columns
     * @return SearchRecords
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
     * @return SearchRecords
     */
    public function fromIndex($index)
    {
        $this->request->setParam('fromIndex', (int) $index);
        return $this;
    }

    /**
     * @param int $index
     * @return SearchRecords
     */
    public function toIndex($index)
    {
        $this->request->setParam('toIndex', (int) $index);
        return $this;
    }

    /**
     * Include the empty fields in the response.
     *
     * @return SearchRecords
     */
    public function withEmptyFields()
    {
        $this->request->setParam('newFormat', "2");
        return $this;
    }

    /**
     * Search record by an equal criteria.
     * Could be multiple 'wheres' into a single request
     * i.e: ('First Name', 'Cristian')
     *
     * @param $field string
     * @param $value string
     * @return SearchRecords
     */
    public function where($field, $value)
    {
        $this->wheres[$field] = $value;
        $this->parseQueries();
        return $this;
    }

    /**
     * Search record by an equal criteria adding.
     * This function adds a secondary alternative after established 'where(s)'
     * Could be multiple 'orWheres' into a single request
     * i.e: ('Email', 'hsilencee@gmail.com')
     *
     * @param $field string
     * @param $value string
     * @return SearchRecords
     */
    public function orWhere($field, $value)
    {
        $this->orWheres[] = array($field => $value);
        $this->parseQueries();
        return $this;
    }

    private function parseQueries()
    {
        $wheres = '';
        $orWheres = '';

        $wheres_keys = array_keys($this->wheres);
        for ($i = 0; $i < count($wheres_keys); $i++) {
            $current = $wheres_keys[$i];
            $wheres .= '('.$current.':'.$this->wheres[$current].')';
            if(isset($wheres_keys[$i+1])){
                $wheres .= 'AND';
            }
        }
        foreach ($this->orWheres as $item) {
            foreach ($item as $key => $value) {
                $orWheres .= 'OR('.$key.':'.$value.')';
            }
        }
        $query = '(('.$wheres.')'.$orWheres.')';
        $this->request->setParam('criteria', $query);
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
