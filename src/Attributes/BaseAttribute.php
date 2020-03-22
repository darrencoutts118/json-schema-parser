<?php

namespace JsonSchemaParser\Attributes;

use Illuminate\Support\Str;

abstract class BaseAttribute
{
    protected $children = [];
    protected $name;
    protected $extra;

    public function __construct($name, $extra = [])
    {
        $this->name = $name;
        $this->extra = $extra;

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
}
