<?php

namespace JsonSchemaParser\Attributes;

use Illuminate\Support\Str;

abstract class BaseAttribute
{
    protected $children = [];
    protected $name;
    protected $extra;
    protected $value = null;
    protected $path = null;

    public function __construct($name, $path, $extra = [])
    {
        $this->name = $name;
        $this->extra = $extra;
        $this->path = $path;

        $this->boot();
    }

    protected function boot()
    {
        // do nothing
    }

    public function name()
    {
        return $this->name;
    }

    public function title()
    {
        return Str::title(str_replace('_', ' ', $this->name));
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }

    public function fqn()
    {
        return implode('.', array_filter([$this->path, $this->name]));
    }
}
