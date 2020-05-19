<?php

namespace JsonSchemaParser\Attributes;

use JsonSchemaParser\Exceptions\InvalidNumberValueException;

class NumberAttribute extends BaseAttribute implements ScalarAttribute
{
    public function validate()
    {
        if (!is_numeric($this->value)) {
            throw new InvalidNumberValueException($this->fqn(), $this->value);
        }

        return true;
    }
}
