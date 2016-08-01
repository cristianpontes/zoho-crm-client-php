<?php
namespace CristianPontes\ZohoCRMClient\Response;

/**
 * Record
 */
class Record
{
    private $index;
    private $data;

    /**
     * @param array $data
     * @param int $index
     */
    function __construct(array $data, $index = null)
    {
        $this->index = $index;
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return array_key_exists($key, $this->data) ? $this->data[$key] : $default;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
} 