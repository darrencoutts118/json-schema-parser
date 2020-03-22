<?php

namespace JsonSchemaParser;

class GenerationTest extends BaseTest
{
    /* @test */
    public function testGenerateSchemaInstance()
    {
        // setup
        $schema = new Schema();

        // assert
        $this->assertInstanceOf(Schema::class, $schema);
    }
}
