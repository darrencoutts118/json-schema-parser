<?php

namespace JsonSchemaParser\Attributes;

class ArrayAttribute extends BaseAttribute
{
    protected $items;
    protected $value = [];

    protected function boot()
    {
        $items = $this->extra->items;
        $class = 'JsonSchemaParser\\Attributes\\' . ucfirst($items->type) . 'Attribute';

        $this->items = new $class(null, $items);
    }

    public function items()
    {
        return $this->items;
    }

    public function property($property)
    {
        return $this->items->property($property);
    }

    public function newItem($value = null)
    {
        $this->value[] = clone $this->items;
        $element = $this->value[count($this->value) - 1];

        if (!is_null($value)) {
            $element->setValue($value);
        }

        return $element;
    }

    public function setValue($value)
    {
        foreach ((array) $value as $element) {
            $this->newItem($element);
        }
    }

    public function array()
    {
        $return = [];

        foreach ($this->value as $value) {
            $return[] = $value;
        }

        return $return;
    }

    public function value($property = null)
    {
        if (is_null($property)) {
            return $this->value;
        }

        $return = [];

        foreach ($this->value as $value) {
            if ($value instanceof BaseAttribute) {
                $return[] = $value->value();
            } else {
                $return[] = $value;
            }
        }

        return $return;
    }
}
