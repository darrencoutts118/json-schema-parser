<?php

namespace JsonSchemaParser\Tests;

use JsonSchemaParser\Attributes\NumberAttribute;
use JsonSchemaParser\Attributes\ObjectAttribute;
use JsonSchemaParser\Attributes\StringAttribute;

class NestedObjectTest extends BaseTest
{
    /* @test */
    public function testNestedObjectsAreCreated()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->assertInstanceOf(ObjectAttribute::class, $schema->asSchema());
        $this->assertInstanceOf(ObjectAttribute::class, $schema->asSchema()->properties()['account']);
    }

    /* @test */
    public function testNestedObjectsCreateProperties()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->assertInstanceOf(ObjectAttribute::class, $schema->asSchema());
        $this->assertInstanceOf(ObjectAttribute::class, $schema->asSchema()->properties()['account']);

        $this->assertCount(12, $schema->asSchema()->properties()['account']->properties());

        $property = $schema->asSchema()->properties()['account']->properties()['avatar_url'];
        $this->assertInstanceOf(StringAttribute::class, $property);
        $this->assertEquals('avatar_url', $property->name());

        $property = $schema->asSchema()->properties()['account']->properties()['id'];
        $this->assertInstanceOf(NumberAttribute::class, $property);
        $this->assertEquals('id', $property->name());
    }
}
