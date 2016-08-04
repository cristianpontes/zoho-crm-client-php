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
    public $error;
    /** @var int */
    public $index;
    /** @var string */
    public $code;
    /** @var int */
    public $id;
    /** @var DateTime */
    public $createdTime;
    /** @var DateTime */
    public $modifiedTime;
    /** @var string */
    public $createdBy;
    /** @var string */
    public $modifiedBy;

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
     * @return bool
     */
    public function isDeleted()
    {
        return $this->code == '5000' || $this->code == "4800";
    }

    /**
     * @return bool
     */
    public function isUploaded()
    {
        return $this->code === '4800';
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
     * @param string $createdTime
     * @return MutationResult self
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * @param string $modifiedTime
     * @return MutationResult self
     */
    public function setModifiedTime($modifiedTime)
    {
        $this->modifiedTime = $modifiedTime;
        return $this;
    }

    /**
     * @return string
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