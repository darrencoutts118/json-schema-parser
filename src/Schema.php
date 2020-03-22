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
}
