<?php

namespace JsonSchemaParser;

class Schema
{
    protected $json;
    protected $object;
    protected $schema;

    public function __construct($json = null)
    {
        $this->json = $json;

        if (!empty($this->json)) {
            // we have the json, boot the instance
            $this->boot();
        }
    }

    public function boot()
    {
        $this->object = json_decode($this->json);

        $class = 'JsonSchemaParser\\Attributes\\' . ucfirst($this->object->type) . 'Attribute';
        $this->schema = new $class(null, $this->object);
    }

    public function asJson()
    {
        return $this->json;
    }

    public function asSchema()
    {
        return $this->schema;
    }

    public function property($property)
    {
        return $this->schema->property($property);
    }

    public function value($property)
    {
        return $this->schema->value($property);
    }

    public function fill($values)
    {
        if (is_string($values)) {
            $values = json_decode($values);
        }

        return $this->schema->setValue($values);
    }

    public function __get($property)
    {
        return $this->schema->{$property};
    }
}
