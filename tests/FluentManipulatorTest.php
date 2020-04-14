<?php

namespace JsonSchemaParser\Tests;

use JsonSchemaParser\Attributes\ObjectAttribute;
use JsonSchemaParser\FluentManipulator;

class FluentManipulatorTest extends BaseTest
{
    /* @test */
    public function testAFluentManipulatorCanBeCreated()
    {
        $schema = $this->createFilledSchema();

        $this->assertInstanceOf(FluentManipulator::class, new FluentManipulator($schema, null));
    }

    /* @test */
    public function testTheFirstItemIsAddedToThePath()
    {
        $schema = $this->createFilledSchema();

        $fluent = new FluentManipulator($schema, 'account');

        $this->assertInstanceOf(FluentManipulator::class, $fluent);
        $this->assertIsArray($fluent->path());
        $this->assertCount(1, $fluent->path());
        $this->assertEquals('account', $fluent->path()[0]);
    }

    /* @test */
    public function testMultipleItemsCanBeAddedToThePath()
    {
        $schema = $this->createFilledSchema();

        $fluent = (new FluentManipulator($schema, 'account'))->avatar_url;

        $this->assertInstanceOf(FluentManipulator::class, $fluent);
        $this->assertIsArray($fluent->path());
        $this->assertCount(2, $fluent->path());
        $this->assertEquals('account', $fluent->path()[0]);
        $this->assertEquals('avatar_url', $fluent->path()[1]);
    }

    /* @test */
    public function testEachMagicMethodCanBeAddedToThePath()
    {
        $schema = $this->createFilledSchema();

        $fluent = (new FluentManipulator($schema, 'repositories'))->each()->allow_merge_commit;

        $this->assertInstanceOf(FluentManipulator::class, $fluent);
        $this->assertIsArray($fluent->path());
        $this->assertCount(3, $fluent->path());
        $this->assertEquals(['repositories', '*', 'allow_merge_commit'], $fluent->path());
    }

    /* @test */
    public function testAnArrayIndexCanBeAddedToThePath()
    {
        $schema = $this->createFilledSchema();

        $fluent = (new FluentManipulator($schema, 'repositories'))[0]->allow_merge_commit;

        $this->assertInstanceOf(FluentManipulator::class, $fluent);
        $this->assertIsArray($fluent->path());
        $this->assertCount(3, $fluent->path());
        $this->assertEquals(['repositories', '0', 'allow_merge_commit'], $fluent->path());
    }

    /* @test */
    public function testDifferentMutatorsCanBeUsedAtOnce()
    {
        $schema = $this->createFilledSchema();

        $fluent = (new FluentManipulator($schema, 'repositories'))[0]->owner->avatar_url;

        $this->assertInstanceOf(FluentManipulator::class, $fluent);
        $this->assertIsArray($fluent->path());
        $this->assertCount(4, $fluent->path());
        $this->assertEquals(['repositories', '0', 'owner', 'avatar_url'], $fluent->path());
    }

    /* @test */
    public function testThePathCanBeCompiled()
    {
        $schema = $this->createFilledSchema();

        $fluent = (new FluentManipulator($schema, 'repositories'))[0]->owner->avatar_url;
        $expected = 'repositories.0.owner.avatar_url';

        $this->assertInstanceOf(FluentManipulator::class, $fluent);
        $this->assertIsArray($fluent->path());
        $this->assertCount(4, $fluent->path());
        $this->assertEquals(['repositories', '0', 'owner', 'avatar_url'], $fluent->path());
        $this->assertIsString($fluent->compile());
        $this->assertEquals($expected, $fluent->compile());
    }

    /* @test */
    public function testAStringValueCanBeReturned()
    {
        $schema = $this->createFilledSchema();

        $fluent = (new FluentManipulator($schema, 'repositories'))[0]->owner->avatar_url;
        $expected = 'https://github.com/images/error/octocat_happy.gif';

        $this->assertIsString($fluent->value());
        $this->assertEquals($expected, $fluent->value());
    }

    /* @test */
    public function testABooleanValueCanBeReturned()
    {
        $schema = $this->createFilledSchema();

        $fluent = (new FluentManipulator($schema, 'repositories'))[0]->allow_merge_commit;
        $expected = true;

        $this->assertIsBool($fluent->value());
        $this->assertEquals($expected, $fluent->value());
    }

    /* @test */
    public function testANumberValueCanBeReturned()
    {
        $schema = $this->createFilledSchema();

        $fluent = (new FluentManipulator($schema, 'repositories'))[0]->forks_count;
        $expected = 9;

        $this->assertIsInt($fluent->value());
        $this->assertEquals($expected, $fluent->value());
    }

    /* @test */
    public function testAnArrayValueCanBeReturned()
    {
        $schema = $this->createFilledSchema();

        $fluent = (new FluentManipulator($schema, 'repositories'))[0]->topics;
        $expected = ['octocat', 'atom', 'electron', 'api'];

        $this->assertIsArray($fluent->value());
        $this->assertEquals($expected, $fluent->value());
    }

    /* @test */
    public function testAnObjectValueCanBeReturned()
    {
        $schema = $this->createFilledSchema();

        $fluent = (new FluentManipulator($schema, 'repositories'))[0]->permissions;

        $this->assertIsObject($fluent->value());
        $this->assertObjectHasAttribute('admin', $fluent->value());
        $this->assertObjectHasAttribute('push', $fluent->value());
        $this->assertObjectHasAttribute('pull', $fluent->value());
        $this->assertEquals(false, $fluent->value()->admin);
        $this->assertEquals(false, $fluent->value()->push);
        $this->assertEquals(true, $fluent->value()->pull);
    }

    /* @test */
    public function testAutoValueFlagCanBeSet()
    {
        $schema = $this->createFilledSchema();

        $fluent = (new FluentManipulator($schema, 'repositories'));

        // starts out false
        $this->assertEquals(false, $fluent->autoValueEnabled());

        // enable it
        $fluent = $fluent->autoValue(true);
        $this->assertEquals(true, $fluent->autoValueEnabled());

        // enable it
        $fluent = $fluent->autoValue(false);
        $this->assertEquals(false, $fluent->autoValueEnabled());

        // enable it magically
        $fluent = $fluent->autoValue();
        $this->assertEquals(true, $fluent->autoValueEnabled());
    }

    /* @test */
    public function testAStringValueCanBeReturnedByAutoValue()
    {
        $schema = $this->createFilledSchema();

        $value = (new FluentManipulator($schema, 'repositories'))->autoValue()[0]->owner->avatar_url;
        $expected = 'https://github.com/images/error/octocat_happy.gif';

        $this->assertIsString($value);
        $this->assertEquals($expected, $value);
    }

    /* @test */
    public function testABooleanValueCanBeReturnedByAutoValue()
    {
        $schema = $this->createFilledSchema();

        $fluent = (new FluentManipulator($schema, 'repositories'))->autoValue()[0]->allow_merge_commit;
        $expected = true;

        $this->assertIsBool($fluent);
        $this->assertEquals($expected, $fluent);
    }

    /* @test */
    public function testANumberValueCanBeReturnedByAutoValue()
    {
        $schema = $this->createFilledSchema();

        $fluent = (new FluentManipulator($schema, 'repositories'))->autoValue()[0]->forks_count;
        $expected = 9;

        $this->assertIsInt($fluent);
        $this->assertEquals($expected, $fluent);
    }
}
