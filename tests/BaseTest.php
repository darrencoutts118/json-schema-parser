<?php

namespace JsonSchemaParser\Tests;

use JsonSchemaParser\Schema;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    public function createSchema()
    {
        $json = file_get_contents(__DIR__ . '/assets/schema.json');
        $schema = new Schema($json);
        return $schema;
    }

    public function createFilledSchema()
    {
        $json = file_get_contents(__DIR__ . '/assets/schema.json');
        $schema = new Schema($json);
        $schema->fill(json_decode(file_get_contents(__DIR__ . '/assets/example.json')));
        return $schema;
    }
}
