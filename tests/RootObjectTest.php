<?php

namespace JsonSchemaParser\Tests;

use JsonSchemaParser\Attributes\ArrayAttribute;
use JsonSchemaParser\Attributes\NumberAttribute;
use JsonSchemaParser\Attributes\ObjectAttribute;
use JsonSchemaParser\Attributes\StringAttribute;

class RootObjectTest extends BaseTest
{
    /* @test */
    public function testTheRootElementHasNoName()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->assertNull($schema->asSchema()->name());
    }

    /* @test */
    public function testTheRootElementHasTheCorrectNumberOfProperties()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->assertCount(15, $schema->asSchema()->properties());
    }

    /* @test */
    public function testTheRootElementCreatesStringProperties()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->assertInstanceOf(StringAttribute::class, $schema->asSchema()->properties()['access_tokens_url']);
        $this->assertEquals('access_tokens_url', $schema->asSchema()->properties()['access_tokens_url']->name());
    }

    /* @test */
    public function testTheRootElementCreatesNumberProperties()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->assertInstanceOf(NumberAttribute::class, $schema->asSchema()->properties()['target_id']);
        $this->assertEquals('target_id', $schema->asSchema()->properties()['target_id']->name());
    }

    /* @test */
    public function testTheRootElementCreatesArrayProperties()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->assertInstanceOf(ArrayAttribute::class, $schema->asSchema()->properties()['events']);
        $this->assertEquals('events', $schema->asSchema()->properties()['events']->name());
    }

    /* @test */
    public function testTheRootElementCreatesObjectProperties()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->assertInstanceOf(ObjectAttribute::class, $schema->asSchema()->properties()['account']);
        $this->assertEquals('account', $schema->asSchema()->properties()['account']->name());
    }
}
