<?php

namespace JsonSchemaParser\Tests;

class ValueFluentNotationTest extends BaseTest
{
    /* @test */
    public function testATextAttributeCanBeAccessedAtRootLevel()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $expected = 'https://api.github.com/installations/1/access_tokens';
        $this->assertEquals($expected, $schema->asSchema()->access_tokens_url);
        $this->assertEquals($expected, $schema->access_tokens_url);
    }

    /* @test */
    public function testABooleanAttributeCanBeAccessedAtRootLevel()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $expected = true;
        $this->assertEquals($expected, $schema->asSchema()->target_owner);
        $this->assertEquals($expected, $schema->target_owner);
    }

    /* @test */
    public function testANumberAttributeCanBeAccessedAtRootLevel()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $expected = 1;
        $this->assertEquals($expected, $schema->asSchema()->app_id);
        $this->assertEquals($expected, $schema->app_id);
    }
}
