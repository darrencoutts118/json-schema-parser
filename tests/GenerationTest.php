<?php

namespace JsonSchemaParser;

use JsonSchemaParser\Attributes\ObjectAttribute;
use JsonSchemaParser\Attributes\StringAttribute;

class GenerationTest extends BaseTest
{
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
        $json = file_get_contents(__DIR__ . '/assets/schema.json');
        $schema = new Schema($json);

        // assert
        $this->assertInstanceOf(ObjectAttribute::class, $schema->asSchema());
    }

    /* @test */
    public function testTheRootElementHasNoName()
    {
        // setup
        $json = file_get_contents(__DIR__ . '/assets/schema.json');
        $schema = new Schema($json);

        // assert
        $this->assertNull($schema->asSchema()->name());
    }

    /* @test */
    public function testTheRootElementHasTheCorrectNumberOfProperties()
    {
        // setup
        $json = file_get_contents(__DIR__ . '/assets/schema.json');
        $schema = new Schema($json);

        // assert
        $this->assertCount(12, $schema->asSchema()->properties());
    }

    /* @test */
    public function testTheRootElementCreatesStringProperties()
    {
        // setup
        $json = file_get_contents(__DIR__ . '/assets/schema.json');
        $schema = new Schema($json);

        // assert
        $this->assertInstanceOf(StringAttribute::class, $schema->asSchema()->properties()['access_tokens_url']);
        $this->assertEquals('access_tokens_url', $schema->asSchema()->properties()['access_tokens_url']->name());
    }
}
