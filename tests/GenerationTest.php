<?php

namespace JsonSchemaParser\Tests;

use JsonSchemaParser\Schema;
use JsonSchemaParser\Attributes\ObjectAttribute;

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
        $schema = $this->createSchema();

        // assert
        $this->assertInstanceOf(ObjectAttribute::class, $schema->asSchema());
    }
}
