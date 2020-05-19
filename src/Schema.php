<?php

namespace JsonSchemaParser;

use JsonSchemaParser\Attributes\BaseAttribute;
use JsonSchemaParser\Attributes\StringAttribute;

class Schema
{
    protected $json;
    protected $object;
    protected $schema;
    protected $simpleSchema = null;

    public function __construct($json = null)
    {
        $this->json = $json;

        if (!empty($this->json) || $json === false) {
            // we have the json, boot the instance
            $this->boot();
        }
    }

    public function boot()
    {
        if (is_bool($this->json)) {
            $this->schema = new SimpleSchema($this->json);
            return;
        }

        $this->object = json_decode($this->json);

        if (empty((array) $this->object)) {
            $this->schema = new SimpleSchema(true);
            return;
        }

        $class = 'JsonSchemaParser\\Attributes\\' . ucfirst($this->object->type) . 'Attribute';
        $this->schema = new $class(null, null, $this->object);
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
            if (!$this->schema instanceof StringAttribute) {
                $values = json_decode($values);
            }
        }

        $this->schema->setValue($values);

        return $this->schema->validate();
    }

    public function __get($property): BaseAttribute
    {
        return $this->schema->{$property};
    }

    public function validate()
    {
        return $this->schema->validate();
    }

    public function isValid()
    {
        return $this->validate();
    }
}
