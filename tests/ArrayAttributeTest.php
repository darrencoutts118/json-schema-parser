<?php

namespace JsonSchemaParser\Tests;

use JsonSchemaParser\Attributes\BooleanAttribute;
use JsonSchemaParser\Attributes\NumberAttribute;
use JsonSchemaParser\Attributes\ObjectAttribute;
use JsonSchemaParser\Attributes\StringAttribute;

class ArrayAttributeTest extends BaseTest
{
    /* @test */
    public function testArraysCreateItemsObject()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->assertInstanceOf(StringAttribute::class, $schema->asSchema()->properties()['events']->items());
        $this->assertInstanceOf(ObjectAttribute::class, $schema->asSchema()->properties()['repositories']->items());
    }

    /* @test */
    public function testArraysWithObjectsCreateProtperties()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->assertInstanceOf(ObjectAttribute::class, $schema->asSchema()->property('repositories')->items());
        $this->assertCount(80, $schema->asSchema()->property('repositories')->items()->properties());

        $property = $schema->asSchema()->property('repositories')->items()->property('allow_merge_commit');
        $this->assertInstanceOf(BooleanAttribute::class, $property);

        $property = $schema->asSchema()->property('repositories')->items()->property('allow_merge_commit');
        $this->assertInstanceOf(BooleanAttribute::class, $property);
    }

    /* @test */
    public function testArraysWithObjectsCreateNestedObjectProtperties()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $owner = $schema->asSchema()->property('repositories')->items()->property('owner');
        $this->assertInstanceOf(ObjectAttribute::class, $owner);
        $this->assertCount(18, $owner->properties());

        $property = $owner->property('avatar_url');
        $this->assertInstanceOf(StringAttribute::class, $property);

        $property = $owner->property('id');
        $this->assertInstanceOf(NumberAttribute::class, $property);
    }
}
