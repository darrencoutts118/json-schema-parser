<?php

namespace JsonSchemaParser\Tests;

use JsonSchemaParser\Schema;
use JsonSchemaParser\SimpleSchema;

class HelloWorldTest extends BaseTest
{
    /* @test */
    public function testEmptySchema()
    {
        // setup
        $schema = new Schema('{}');
        $schema->fill(42);

        // assert
        $this->assertInstanceOf(SimpleSchema::class, $schema->asSchema());
        $this->assertTrue($schema->isValid());

        $schema->fill('I\'m a string');
        $this->assertTrue($schema->isValid());

        $value = json_decode('{ "an": [ "arbitrarily", "nested" ], "data": "structure" }');
        $schema->fill($value);
        $this->assertTrue($schema->isValid());
    }

    /* @test */
    public function testTrueSchema()
    {
        // setup
        $schema = new Schema(true);
        $schema->fill(42);

        // assert
        $this->assertInstanceOf(SimpleSchema::class, $schema->asSchema());
        $this->assertTrue($schema->isValid());

        $schema->fill('I\'m a string');
        $this->assertTrue($schema->isValid());

        $value = json_decode('{ "an": [ "arbitrarily", "nested" ], "data": "structure" }');
        $schema->fill($value);
        $this->assertTrue($schema->isValid());
    }

    /* @test */
    public function testFalseSchema()
    {
        // setup
        $schema = new Schema(false);
        $schema->fill(42);

        // assert
        $this->assertInstanceOf(SimpleSchema::class, $schema->asSchema());
        $this->assertFalse($schema->isValid());

        $schema->fill('I\'m a string');
        $this->assertFalse($schema->isValid());

        $value = json_decode('{ "an": [ "arbitrarily", "nested" ], "data": "structure" }');
        $schema->fill($value);
        $this->assertFalse($schema->isValid());
    }
}
