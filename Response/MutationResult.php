<?php
namespace CristianPontes\ZohoCRMClient\Response;

use CristianPontes\ZohoCRMClient\ZohoError;
use DateTime;

/**
 * MutationResult the result of either a insert or update
 */
class MutationResult
{
    /** @var ZohoError */
    private $error;
    /** @var int */
    private $index;
    /** @var string */
    private $code;
    /** @var int */
    private $id;
    /** @var DateTime */
    private $createdTime;
    /** @var DateTime */
    private $modifiedTime;
    /** @var string */
    private $createdBy;
    /** @var string */
    private $modifiedBy;

    /**
     * @param int $index
     * @param string $code
     */
    public function __construct($index, $code)
    {
        $this->index = $index;
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return bool
     */
    public function isInserted()
    {
        return $this->code == '2000';
    }

    /**
     * @return bool
     */
    public function isUpdated()
    {
        return $this->code == '2001';
    }

    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return $this->code == '2002';
    }

    /**
     * @param ZohoError $error
     * @return MutationResult
     */
    public function setError(ZohoError $error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @return ZohoError|void
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return bool
     */
    public function isError()
    {
        return $this->error instanceof ZohoError;
    }

    /**
     * @param int $id
     * @return MutationResult self
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \DateTime $createdTime
     * @return MutationResult self
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * @param \DateTime $modifiedTime
     * @return MutationResult self
     */
    public function setModifiedTime($modifiedTime)
    {
        $this->modifiedTime = $modifiedTime;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getModifiedTime()
    {
        return $this->modifiedTime;
    }

    /**
     * @param string $createdBy
     * @return MutationResult self
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param string $modifiedBy
     * @return MutationResult self
     */
    public function setModifiedBy($modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;
        return $this;
    }

    /**
     * @return string
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }
}