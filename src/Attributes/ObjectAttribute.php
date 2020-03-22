<?php

namespace JsonSchemaParser\Attributes;

class ObjectAttribute extends BaseAttribute
{
    protected $properties = [];

    public function properties()
    {
        return $this->properties;
    }

    protected function boot()
    {
        foreach ($this->extra->properties as $name => $schema) {
            $this->properties[$name] = new StringAttribute($name, $schema);
        }
    }
}
