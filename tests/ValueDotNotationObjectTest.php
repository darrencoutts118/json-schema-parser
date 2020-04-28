<?php

namespace JsonSchemaParser\Tests;

class ValueDotNotationObjectTest extends BaseTest
{
    /* @test */
    public function testAnObjectAttributeCanBeAccessedAtRootLevel()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $expected = 'https://github.com/images/error/octocat_happy.gif';
        $this->assertIsObject($schema->asSchema()->value('account'));
        $this->assertObjectHasAttribute('avatar_url', $schema->asSchema()->value('account'));
        $this->assertIsString($schema->asSchema()->value('account')->avatar_url);
        $this->assertEquals($expected, $schema->asSchema()->value('account')->avatar_url);

        $this->assertIsObject($schema->value('account'));
        $this->assertObjectHasAttribute('avatar_url', $schema->value('account'));
        $this->assertIsString($schema->value('account')->avatar_url);
        $this->assertEquals($expected, $schema->value('account')->avatar_url);
    }

    /* @test */
    public function testAStringAttribueCanBeAccessedOnAnObject()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $expected = 'https://github.com/images/error/octocat_happy.gif';
        $this->assertIsObject($schema->asSchema()->value('account'));
        $this->assertIsString($schema->asSchema()->value('account.avatar_url'));
        $this->assertEquals($expected, $schema->asSchema()->value('account.avatar_url'));

        $this->assertIsObject($schema->value('account'));
        $this->assertIsString($schema->value('account.avatar_url'));
        $this->assertEquals($expected, $schema->value('account.avatar_url'));
    }
}
