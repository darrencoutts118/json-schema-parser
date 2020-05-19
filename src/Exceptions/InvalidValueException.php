<?php

namespace JsonSchemaParser\Exceptions;

use Exception;

class InvalidValueException extends Exception
{
    public function __construct($fqn, $expected, $actual)
    {
        $message = 'The property ';

        if (!empty($fqn)) {
            $message .= $fqn . ' ';
        }

        $message .= 'expected a ' . $expected . ', ' . gettype($actual) . ' given.';

        parent::__construct($message);
    }
}
