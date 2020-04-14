<?php

namespace JsonSchemaParser;

use Exception;
use ArrayAccess;
use JsonSchemaParser\Attributes\ArrayAttribute;
use JsonSchemaParser\Attributes\ScalarAttribute;
use Illuminate\Support\Str;

class FluentManipulator implements ArrayAccess
{
    protected $path = [];
    protected $schema;
    protected $autoValue = false;

    public function __construct($schema, $first)
    {
        $this->schema = $schema;
        $this->path[] = $first;
    }

    public function __get($name)
    {
        $this->path[] = $name;

        $autoValue = $this->checkForValue();
        if (!is_null($autoValue)) {
            return $autoValue;
        }

        return $this;
    }

    public function checkForValue()
    {
        // check if we are autovaluing
        if ($this->autoValue) {
            $property = $this->schema->property($this->compile());

            if ($property instanceof ScalarAttribute) {
                return $this->value();
            }

            if ($property instanceof ArrayAttribute && $property->items() instanceof ScalarAttribute) {
                if (is_numeric(Str::afterLast($this->compile(), '.'))) {
                    return $this->value();
                }
            }
        }

        return null;
    }

    public function each()
    {
        $this->path[] = '*';

        return $this;
    }

    public function offsetGet($offset)
    {
        $this->path[] = $offset;

        $autoValue = $this->checkForValue();
        if (!is_null($autoValue)) {
            return $autoValue;
        }

        return $this;
    }

    public function path()
    {
        return $this->path;
    }

    public function compile()
    {
        return implode('.', $this->path);
    }

    public function value()
    {
        return $this->schema->value($this->compile());
    }

    public function autoValue($status = true)
    {
        $this->autoValue = $status;

        $autoValue = $this->checkForValue();
        if (!is_null($autoValue)) {
            return $autoValue;
        }

        return $this;
    }

    public function autoValueEnabled()
    {
        return $this->autoValue;
    }

    public function offsetExists($offset)
    {
        throw new Exception(__METHOD__ . ' not implemented');
    }

    public function offsetSet($offset, $value)
    {
        throw new Exception(__METHOD__ . ' not implemented');
    }

    public function offsetUnset($offset)
    {
        throw new Exception(__METHOD__ . ' not implemented');
    }
}
