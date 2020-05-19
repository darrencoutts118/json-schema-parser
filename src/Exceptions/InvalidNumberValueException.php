<?php

namespace JsonSchemaParser\Exceptions;

class InvalidNumberValueException extends InvalidValueException
{
    public function __construct($fqn, $actual)
    {
        parent::__construct($fqn, 'number', $actual);
    }
}
