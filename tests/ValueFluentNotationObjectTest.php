<?php

namespace JsonSchemaParser\Tests;

class ValueFluentNotationObjectTest extends BaseTest
{
    /* @test */
    public function testAnObjectAttributeCanBeAccessedAtRootLevel()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $expected = 'https://github.com/images/error/octocat_happy.gif';
        $this->assertIsObject($schema->asSchema()->account->value());
        $this->assertObjectHasAttribute('avatar_url', $schema->asSchema()->account->value());
        $this->assertIsString($schema->asSchema()->account->avatar_url);
        $this->assertEquals($expected, $schema->asSchema()->account->avatar_url);

        $this->assertIsObject($schema->account->value());
        $this->assertObjectHasAttribute('avatar_url', $schema->account->value());
        $this->assertIsString($schema->account->avatar_url);
        $this->assertEquals($expected, $schema->account->avatar_url);
    }

    /* @test */
    public function testAStringAttribueCanBeAccessedOnAnObject()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $expected = 'https://github.com/images/error/octocat_happy.gif';
        $this->assertIsObject($schema->asSchema()->account);
        $this->assertIsString($schema->asSchema()->account->avatar_url);
        $this->assertEquals($expected, $schema->asSchema()->account->avatar_url);

        $this->assertIsObject($schema->account);
        $this->assertIsString($schema->account->avatar_url);
        $this->assertEquals($expected, $schema->account->avatar_url);
    }
}
