<?php

namespace JsonSchemaParser\Attributes;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use JsonSchemaParser\Exceptions\PropertyNotFoundException;

class ObjectAttribute extends BaseAttribute
{
    protected $properties;
    protected $value = [];

    public function __construct($name, $extra = [])
    {
        $this->properties = new Collection();

        parent::__construct($name, $extra);
    }

    protected function boot()
    {
        foreach ($this->extra->properties as $name => $schema) {
            $class = 'JsonSchemaParser\\Attributes\\' . ucfirst($schema->type) . 'Attribute';
            $this->properties[$name] = new $class($name, $schema);
        }
    }

    public function properties()
    {
        return $this->properties;
    }

    public function property($property)
    {
        if (Str::contains($property, '.')) {
            // this is looking for a sub property
            if (!isset($this->properties[Str::before($property, '.')])) {
                throw new PropertyNotFoundException('Property ' . $property . ' is not found in this schema');
            }

            return $this->properties[Str::before($property, '.')]->property(Str::after($property, '.'));
        }

        if (!isset($this->properties[$property])) {
            throw new PropertyNotFoundException('Property ' . $property . ' is not found in this schema');
        }

        return $this->properties[$property];
    }

    public function setValue($values)
    {
        foreach ($values as $property => $value) {
            $this->property($property)->setValue($value);
        }
    }

    public function array()
    {
        $return = [];

        foreach ($this->properties as $property) {
            $return[$property->name()] = $property;
        }

        return $return;
    }

    public function object()
    {
        return (object) $this->array();
    }

    public function value($property = null)
    {
        return $this->property($property)->value();
    }

    public function __clone()
    {
        $this->properties = clone $this->properties;

        foreach ($this->properties->keys() as $property) {
            $this->properties[$property] = clone $this->properties[$property];
        }
    }
}
