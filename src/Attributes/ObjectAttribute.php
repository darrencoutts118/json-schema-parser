<?php

namespace JsonSchemaParser\Attributes;

use Illuminate\Support\Collection;

class ObjectAttribute extends BaseAttribute
{
    protected $properties;

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
}
