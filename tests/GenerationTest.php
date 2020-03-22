<?php

namespace JsonSchemaParser;

use JsonSchemaParser\Attributes\ObjectAttribute;
use JsonSchemaParser\Attributes\StringAttribute;

class GenerationTest extends BaseTest
{
    public function createSchema()
    {
        $json = file_get_contents(__DIR__ . '/assets/schema.json');
        $schema = new Schema($json);
        return $schema;
    }

    /* @test */
    public function testGenerateSchemaInstance()
    {
        // setup
        $schema = new Schema();

        // assert
        $this->assertInstanceOf(Schema::class, $schema);
        $this->assertNull($schema->asJson());
    }

    /* @test */
    public function testGenerateSchemaFromJson()
    {
        // setup
        $json = file_get_contents(__DIR__ . '/assets/schema.json');
        $schema = new Schema($json);

        // assert
        $this->assertNotNull($schema->asJson());
    }

    /* @test */
    public function testItGeneratesTheRootElement()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->assertInstanceOf(ObjectAttribute::class, $schema->asSchema());
    }

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
        $this->assertCount(12, $schema->asSchema()->properties());
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
    public function testAttributesContainHumanReadableTitles()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->assertEquals('access_tokens_url', $schema->asSchema()->properties()['access_tokens_url']->name());
        $this->assertEquals('Access Tokens Url', $schema->asSchema()->properties()['access_tokens_url']->title());
    }
}
