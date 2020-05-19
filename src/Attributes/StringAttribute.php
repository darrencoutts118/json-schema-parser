<?php

namespace JsonSchemaParser\Attributes;

use JsonSchemaParser\Exceptions\InvalidStringValueException;

class StringAttribute extends BaseAttribute implements ScalarAttribute
{
    public function validate()
    {
        var_dump($this->value);
        die();

        if (!is_string($this->value)) {
            throw new InvalidStringValueException($this->fqn(), $this->value);
        }

        return true;
    }
}
