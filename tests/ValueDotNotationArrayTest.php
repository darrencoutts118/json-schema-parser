<?php

namespace JsonSchemaParser\Tests;

class ValueDotNotationArrayTest extends BaseTest
{
    /* @test */
    public function testAnArrayAttributeCanBeAccessedAtRootLevel()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $this->assertIsArray($schema->asSchema()->value('events'));
        $this->assertCount(2, $schema->asSchema()->value('events'));
        $this->assertEquals(['push', 'pull_request'], $schema->asSchema()->value('events'));

        $this->assertIsArray($schema->value('events'));
        $this->assertCount(2, $schema->value('events'));
        $this->assertEquals(['push', 'pull_request'], $schema->value('events'));
    }

    /* @test */
    public function testAnIndividualItemOfAnArrayCanBeAccessed()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $this->assertIsString($schema->asSchema()->value('events.0'));
        $this->assertEquals('push', $schema->asSchema()->value('events.0'));
        $this->assertIsString($schema->asSchema()->value('events.1'));
        $this->assertEquals('pull_request', $schema->asSchema()->value('events.1'));

        $this->assertIsString($schema->value('events.0'));
        $this->assertEquals('push', $schema->value('events.0'));
        $this->assertIsString($schema->value('events.1'));
        $this->assertEquals('pull_request', $schema->value('events.1'));
    }

    /* @test */
    public function testAnObjectInAnArrayCanBeAccessed()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $expected = 'https://github.com/octocat/Hello-World.git';
        $this->assertIsString($schema->asSchema()->value('repositories.0.clone_url'));
        $this->assertEquals($expected, $schema->asSchema()->value('repositories.0.clone_url'));

        $this->assertIsString($schema->value('repositories.0.clone_url'));
        $this->assertEquals($expected, $schema->value('repositories.0.clone_url'));
    }

    /* @test */
    public function testAnObjectsAttributesInAnArrayCanBeAccessed()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $expected = 'https://github.com/images/error/octocat_happy.gif';
        $this->assertIsString($schema->asSchema()->value('repositories.0.owner.avatar_url'));
        $this->assertEquals($expected, $schema->asSchema()->value('repositories.0.owner.avatar_url'));

        $this->assertIsString($schema->value('repositories.0.owner.avatar_url'));
        $this->assertEquals($expected, $schema->value('repositories.0.owner.avatar_url'));
    }

    /* @test */
    public function testSubArraysCanBeAccessed()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $expected = ['octocat', 'atom', 'electron', 'api'];
        $this->assertIsArray($schema->asSchema()->value('repositories.0.topics'));
        $this->assertEquals($expected, $schema->asSchema()->value('repositories.0.topics'));
        $this->assertEquals($expected[0], $schema->asSchema()->value('repositories.0.topics.0'));

        $this->assertIsArray($schema->value('repositories.0.topics'));
        $this->assertEquals($expected, $schema->value('repositories.0.topics'));
        $this->assertEquals($expected[0], $schema->value('repositories.0.topics.0'));
    }

    /* @test */
    public function testArraysCanUseEachWildcards()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $expected = [1, 2, 3];
        $this->assertIsArray($schema->asSchema()->value('integrations.*.id'));
        $this->assertEquals($expected, $schema->asSchema()->value('integrations.*.id'));

        $this->assertIsArray($schema->value('integrations.*.id'));
        $this->assertEquals($expected, $schema->value('integrations.*.id'));
    }
}
