<?php

namespace JsonSchemaParser;

class GenerationTest extends BaseTest
{
    public function test_generate_blank_schema()
    {
        // setup
        $schema = new Schema();

        // assert
        $this->assertInstanceOf(Schema::class, $schema);
    }
}
