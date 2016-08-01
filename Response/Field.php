<?php
namespace CristianPontes\ZohoCRMClient\Response;

class Field
{
    private $section;
    private $label;
    private $type;
    private $required;
    private $readOnly;
    private $maxLength;
    private $options;
    private $customField;

    public function __construct($section, $label, $type, $required, $readOnly, $maxLength, array $options, $customField)
    {
        $this->section = $section;
        $this->label = $label;
        $this->type = $type;
        $this->required = $required;
        $this->readOnly = $readOnly;
        $this->maxLength = $maxLength;
        $this->options = $options;
        $this->customField = $customField;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isReadOnly()
    {
        return $this->readOnly;
    }

    /**
     * @return int
     */
    public function getMaxLength()
    {
        return $this->maxLength;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return bool
     */
    public function isCustomField()
    {
        return $this->customField;
    }

    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }
} 