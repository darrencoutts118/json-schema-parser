<?php

namespace JsonSchemaParser\Tests;

class ValueFluentNotationArrayTest extends BaseTest
{
    /* @test */
    public function testAnArrayAttributeCanBeAccessedAtRootLevel()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $this->assertIsArray($schema->asSchema()->events->value());
        $this->assertCount(2, $schema->asSchema()->events->value());
        $this->assertEquals(['push', 'pull_request'], $schema->asSchema()->events->value());

        $this->assertIsArray($schema->events->value());
        $this->assertCount(2, $schema->events->value());
        $this->assertEquals(['push', 'pull_request'], $schema->events->value());
    }

    /* @test */
    public function testAnIndividualItemOfAnArrayCanBeAccessed()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $this->assertIsString($schema->asSchema()->events[0]);
        $this->assertEquals('push', $schema->asSchema()->events[0]);
        $this->assertIsString($schema->asSchema()->events[1]);
        $this->assertEquals('pull_request', $schema->asSchema()->events[1]);

        $this->assertIsString($schema->events[0]);
        $this->assertEquals('push', $schema->events[0]);
        $this->assertIsString($schema->events[1]);
        $this->assertEquals('pull_request', $schema->events[1]);
    }

    /* @test */
    public function testAnObjectInAnArrayCanBeAccessed()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $expected = 'https://github.com/octocat/Hello-World.git';
        $this->assertIsString($schema->asSchema()->repositories[0]->clone_url);
        $this->assertEquals($expected, $schema->asSchema()->repositories[0]->clone_url);

        $this->assertIsString($schema->repositories[0]->clone_url);
        $this->assertEquals($expected, $schema->repositories[0]->clone_url);
    }

    /* @test */
    public function testAnObjectsAttributesInAnArrayCanBeAccessed()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $expected = 'https://github.com/images/error/octocat_happy.gif';
        $this->assertIsString($schema->asSchema()->repositories[0]->owner->avatar_url);
        $this->assertEquals($expected, $schema->asSchema()->repositories[0]->owner->avatar_url);

        $this->assertIsString($schema->repositories[0]->owner->avatar_url);
        $this->assertEquals($expected, $schema->repositories[0]->owner->avatar_url);
    }

    /* @test */
    public function testSubArraysCanBeAccessed()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $expected = ['octocat', 'atom', 'electron', 'api'];
        $this->assertIsArray($schema->asSchema()->repositories[0]->topics->value());
        $this->assertEquals($expected, $schema->asSchema()->repositories[0]->topics->value());
        $this->assertEquals($expected[0], $schema->asSchema()->repositories[0]->topics[0]);

        $this->assertIsArray($schema->repositories[0]->topics->value());
        $this->assertEquals($expected, $schema->repositories[0]->topics->value());
        $this->assertEquals($expected[0], $schema->repositories[0]->topics[0]);
    }

    /* @test */
    public function testArraysCanUseEachWildcards()
    {
        // setup
        $schema = $this->createFilledSchema();

        // assert
        $expected = [1, 2, 3];
        $this->assertIsArray($schema->asSchema()->integrations->each()->id);
        $this->assertEquals($expected, $schema->asSchema()->integrations->each()->id);

        $this->assertIsArray($schema->integrations->each()->id);
        $this->assertEquals($expected, $schema->integrations->each()->id);
    }
}
