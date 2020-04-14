<?php

namespace JsonSchemaParser\Tests;

class ValueDotNotationTest extends BaseTest
{
    /* @test */
    public function testATextAttributeCanBeAccessedAtRootLevel()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $expected = 'https://api.github.com/installations/1/access_tokens';
        $this->assertEquals($expected, $schema->asSchema()->value('access_tokens_url'));
        $this->assertEquals($expected, $schema->value('access_tokens_url'));
    }

    /* @test */
    public function testABooleanAttributeCanBeAccessedAtRootLevel()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $expected = true;
        $this->assertEquals($expected, $schema->asSchema()->value('target_owner'));
        $this->assertEquals($expected, $schema->value('target_owner'));
    }

    /* @test */
    public function testANumberAttributeCanBeAccessedAtRootLevel()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $expected = 1;
        $this->assertEquals($expected, $schema->asSchema()->value('app_id'));
        $this->assertEquals($expected, $schema->value('app_id'));
    }
}
