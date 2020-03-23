<?php

namespace JsonSchemaParser\Tests;

use JsonSchemaParser\Attributes\ArrayAttribute;
use JsonSchemaParser\Attributes\NumberAttribute;
use JsonSchemaParser\Attributes\ObjectAttribute;
use JsonSchemaParser\Attributes\StringAttribute;
use JsonSchemaParser\Exceptions\PropertyNotFoundException;

class PropertyDotNotationTest extends BaseTest
{
    /* @test */
    public function testPropertiesCanBeAccessed()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->assertInstanceOf(ObjectAttribute::class, $schema->asSchema()->property('account'));
    }

    /* @test */
    public function testPropertiesCanBeAccessedViaRootObject()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->assertInstanceOf(ObjectAttribute::class, $schema->property('account'));
    }

    /* @test */
    public function testNestedPropertiesCanBeAccessed()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->assertInstanceOf(StringAttribute::class, $schema->property('account.avatar_url'));
    }

    /* @test */
    public function testArraysCanBeAccessed()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->assertInstanceOf(ArrayAttribute::class, $schema->property('events'));
        $this->assertInstanceOf(ArrayAttribute::class, $schema->property('repositories'));
        $this->assertInstanceOf(ObjectAttribute::class, $schema->property('repositories')->items());
    }

    /* @test */
    public function testArrayAttributesCanBeAccessed()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->assertInstanceOf(StringAttribute::class, $schema->property('repositories.archive_url'));
    }

    /* @test */
    public function testArrayNestedAttributesCanBeAccessed()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->assertInstanceOf(StringAttribute::class, $schema->property('repositories.owner.avatar_url'));
    }

    /* @test */
    public function testAnExceptionIsThrownIfPropertyDoesNotExist()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->expectException(PropertyNotFoundException::class);

        $schema->property('notfound');
    }

    /* @test */
    public function testAnExceptionIsThrownIfPropertyDoesNotExistWithSubProperties()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->expectException(PropertyNotFoundException::class);

        $schema->property('notfound.somethingelse');
    }

    /* @test */
    public function testAnExceptionIsThrownIfSubPropertyDoesNotExist()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->expectException(PropertyNotFoundException::class);

        $this->assertInstanceOf(ObjectAttribute::class, $schema->property('account'));
        $schema->property('account.notfound');
    }
}
