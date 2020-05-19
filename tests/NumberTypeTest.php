<?php

namespace JsonSchemaParser\Tests;

use JsonSchemaParser\Attributes\NumberAttribute;
use JsonSchemaParser\Exceptions\InvalidNumberValueException;
use JsonSchemaParser\Schema;

class NumberTypeTest extends BaseTest
{
    private $stringSchema = '{ "type": "number" }';

    /* @test */
    public function testNumberAttribuesCanContainIntegerValues()
    {
        // setup
        $schema = new Schema($this->stringSchema);
        $schema->fill(42);

        // assert
        $this->assertInstanceOf(NumberAttribute::class, $schema->asSchema());
        $this->assertTrue($schema->isValid());
    }

    /* @test */
    public function testNumberAttribuesCanNotContainStringValues()
    {
        // setup
        $this->expectException(InvalidNumberValueException::class);
        $this->expectExceptionMessage('The property expected a number, string given.');

        $schema = new Schema($this->stringSchema);
        $schema->fill("I'm a string");

        // assert
        $this->assertInstanceOf(NumberAttribute::class, $schema->asSchema());
        $this->assertFalse($schema->isValid());
    }

    /* @test */
    public function testNumberAttribuesCanNotContainBooleanValues()
    {
        // setup
        $this->expectException(InvalidNumberValueException::class);
        $this->expectExceptionMessage('The property expected a number, boolean given.');

        $schema = new Schema($this->stringSchema);
        $schema->fill(true);

        // assert
        $this->assertInstanceOf(NumberAttribute::class, $schema->asSchema());
        $this->assertFalse($schema->isValid());
    }
}
