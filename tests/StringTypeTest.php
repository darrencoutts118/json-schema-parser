<?php

namespace JsonSchemaParser\Tests;

use JsonSchemaParser\Attributes\StringAttribute;
use JsonSchemaParser\Exceptions\InvalidStringValueException;
use JsonSchemaParser\Schema;

class StringTypeTest extends BaseTest
{
    private $stringSchema = '{ "type": "string" }';

    /* @test */
    public function testStringAttribuesCanContainStringValues()
    {
        // setup
        $schema = new Schema($this->stringSchema);
        $schema->fill("I'm a string");

        // assert
        $this->assertInstanceOf(StringAttribute::class, $schema->asSchema());
        $this->assertTrue($schema->isValid());
    }

    /* @test */
    public function testStringAttribuesCanNotContainIntegerValues()
    {
        // setup
        $this->expectException(InvalidStringValueException::class);
        $this->expectExceptionMessage('The property expected a string, integer given.');

        $schema = new Schema($this->stringSchema);
        $schema->fill(42);

        // assert
        $this->assertInstanceOf(StringAttribute::class, $schema->asSchema());
        $this->assertFalse($schema->isValid());
    }

    /* @test */
    public function testStringAttribuesCanNotContainBooleanValues()
    {
        // setup
        $this->expectException(InvalidStringValueException::class);
        $this->expectExceptionMessage('The property expected a string, boolean given.');

        $schema = new Schema($this->stringSchema);
        $schema->fill(true);

        // assert
        $this->assertInstanceOf(StringAttribute::class, $schema->asSchema());
        $this->assertFalse($schema->isValid());
    }
}
