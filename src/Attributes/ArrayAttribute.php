<?php

namespace JsonSchemaParser\Attributes;

use Illuminate\Support\Str;

class ArrayAttribute extends BaseAttribute
{
    protected $items;
    protected $value = [];

    protected function boot()
    {
        $items = $this->extra->items;
        $class = 'JsonSchemaParser\\Attributes\\' . ucfirst($items->type) . 'Attribute';

        $this->items = new $class(null, $this->fqn(), $items);
    }

    public function items()
    {
        return $this->items;
    }

    public function property($property)
    {
        if (Str::contains($property, '.')) {
            $start = Str::before($property, '.');
            if (is_numeric($start) || $start == '*') {
                $property = Str::after($property, '.');
            }
        } else {
            if (is_numeric($property) || $property == '*') {
                return $this;
            }
        }

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

    public function each($property)
    {
        $return = [];

        $property = Str::after($property, '*.');

        foreach (array_keys($this->value) as $key) {
            $return[] = $this->value($key . '.' . $property);
        }

        return $return;
    }

    public function value($property = null)
    {
        if (!is_null($property)) {
            $index = $property;
            $subProperty = null;

            if (Str::startsWith($property, '*')) {
                return $this->each($property);
            }

            if (Str::contains($property, '.')) {
                $index = Str::before($property, '.');
                $subProperty = Str::after($property, '.');
            }

            return $this->value[$index]->value($subProperty);
        }

        $return = [];

        foreach ($this->value as $value) {
            $return[] = $value->value();
        }

        return $return;
    }
}
