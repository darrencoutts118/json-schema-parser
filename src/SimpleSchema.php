<?php

namespace JsonSchemaParser;

use JsonSchemaParser\Attributes\BaseAttribute;

class SimpleSchema extends BaseAttribute
{
    protected $returnValue;

    public function __construct($returnValue)
    {
        $this->returnValue = $returnValue;
    }

    public function validate()
    {
        return $this->returnValue;
    }
}
