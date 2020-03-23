<?php

namespace JsonSchemaParser\Attributes;

class ArrayAttribute extends BaseAttribute
{
    protected $items;

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
}
