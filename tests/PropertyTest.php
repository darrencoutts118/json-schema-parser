<?php

namespace JsonSchemaParser\Tests;

class PropertyTest extends BaseTest
{
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
