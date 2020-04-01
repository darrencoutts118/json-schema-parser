<?php

namespace JsonSchemaParser\Tests;

use JsonSchemaParser\Attributes\ObjectAttribute;
use JsonSchemaParser\Attributes\StringAttribute;
use stdClass;

class AttributeValueTest extends BaseTest
{
    /* @test */
    public function testAttributesHaveDefaultValues()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->assertNull($schema->property('access_tokens_url')->value()); // string attribue
        $this->assertNull($schema->property('app_id')->value()); // number attribue
        $this->assertNull($schema->property('target_owner')->value()); // boolean attribue
    }

    /* @test */
    public function testATextAttributeCanHaveAValueSet()
    {
        // setup
        $schema = $this->createSchema();

        // act
        $schema->property('access_tokens_url')->setValue('testvalue');

        // assert
        $this->assertEquals('testvalue', $schema->property('access_tokens_url')->value());
    }

    /* @test */
    public function testANumberAttributeCanHaveAValueSet()
    {
        // setup
        $schema = $this->createSchema();

        // act
        $schema->property('app_id')->setValue(12);

        // assert
        $this->assertEquals(12, $schema->property('app_id')->value());
    }

    /* @test */
    public function testABooleanAttributeCanHaveAValueSet()
    {
        // setup
        $schema = $this->createSchema();

        // act
        $schema->property('target_owner')->setValue(true);

        // assert
        $this->assertEquals(true, $schema->property('target_owner')->value());
    }

    /* @test */
    public function testObjectPropertiesCanHaveASetValue()
    {
        // setup
        $schema = $this->createSchema();

        // act
        $schema->property('account.avatar_url')->setValue('https://...');

        // assert
        $this->assertEquals('https://...', $schema->property('account.avatar_url')->value());
    }

    /* @test */
    public function testObjectPropertiesCanHaveAValueSetFromAnArray()
    {
        // setup
        $schema = $this->createSchema();

        // act
        $schema->property('account')->setValue(['avatar_url' => 'https://...']);

        // assert
        $this->assertEquals('https://...', $schema->property('account.avatar_url')->value());
    }

    /* @test */
    public function testObjectPropertiesCanHaveAValueSetFromAnObject()
    {
        // setup
        $schema = $this->createSchema();

        // act
        $value = new stdClass();
        $value->avatar_url = 'https://...';
        $schema->property('account')->setValue($value);

        // assert
        $this->assertEquals('https://...', $schema->property('account.avatar_url')->value());
    }

    /* @test */
    public function testObjectPropertiesCanBeRetrivedAsAnArray()
    {
        // setup
        $schema = $this->createSchema();

        // act
        $schema->property('account')->setValue(['avatar_url' => 'https://...']);

        // assert
        $this->assertIsArray($schema->property('account')->array());
        $this->assertArrayHasKey('avatar_url', $schema->property('account')->array());
        $this->assertEquals('https://...', $schema->property('account')->array()['avatar_url']->value());
    }

    /* @test */
    public function testObjectPropertiesCanBeRetrivedAsAnObject()
    {
        // setup
        $schema = $this->createSchema();

        // act
        $schema->property('account')->setValue(['avatar_url' => 'https://...']);

        // assert
        $this->assertIsObject($schema->property('account')->object());
        $this->assertObjectHasAttribute('avatar_url', $schema->property('account')->object());
        $this->assertEquals('https://...', $schema->property('account')->object()->avatar_url->value());
    }

    /* @test */
    public function testArrayAttributesCanContainSimpleChildren()
    {
        // setup
        $schema = $this->createSchema();

        // act
        $schema->property('events')->newItem()->setValue('push');

        // assert
        $this->assertCount(1, $schema->property('events')->array());
        $this->assertEquals('push', $schema->property('events')->array()[0]->value());

        // act
        $schema->property('events')->newItem()->setValue('pull_request');

        // assert
        $this->assertCount(2, $schema->property('events')->array());
        $this->assertEquals('push', $schema->property('events')->array()[0]->value());
        $this->assertInstanceOf(StringAttribute::class, $schema->property('events')->array()[1]);
        $this->assertEquals('pull_request', $schema->property('events')->array()[1]->value());
    }

    /* @test */
    public function testArrayAttributesCanContainComplexChildren()
    {
        // setup
        $schema = $this->createSchema();

        // act
        $schema->property('repositories')->newItem()->property('allow_merge_commit')->setValue(true);

        // assert
        $this->assertCount(1, $schema->property('repositories')->array());
        $this->assertEquals(true, $schema->property('repositories')->array()[0]->property('allow_merge_commit')->value());

        // act
        $schema->property('repositories')->newItem()->property('allow_merge_commit')->setValue(false);

        // assert
        $this->assertCount(2, $schema->property('repositories')->array());
        $this->assertInstanceOf(ObjectAttribute::class, $schema->property('repositories')->array()[1]);
        $this->assertEquals(true, $schema->property('repositories')->array()[0]->property('allow_merge_commit')->value());
        $this->assertEquals(false, $schema->property('repositories')->array()[1]->property('allow_merge_commit')->value());
    }

    /* @test */
    public function testArrayAttributesCanSetSimpleAttributesByNewItem()
    {
        // setup
        $schema = $this->createSchema();

        // act
        $schema->property('events')->newItem('push');

        // assert
        $this->assertCount(1, $schema->property('events')->array());
        $this->assertEquals('push', $schema->property('events')->array()[0]->value());

        // act
        $schema->property('events')->newItem('pull_request');

        // assert
        $this->assertCount(2, $schema->property('events')->array());
        $this->assertEquals('push', $schema->property('events')->array()[0]->value());
        $this->assertEquals('pull_request', $schema->property('events')->array()[1]->value());
    }

    /* @test */
    public function testArrayAttributesCanSetComplexAttributesByNewItem()
    {
        // setup
        $schema = $this->createSchema();

        // act
        $schema->property('repositories')->newItem(['allow_merge_commit' => true]);

        // assert
        $this->assertCount(1, $schema->property('repositories')->array());
        $this->assertEquals(true, $schema->property('repositories')->array()[0]->property('allow_merge_commit')->value());

        // act
        $schema->property('repositories')->newItem(['allow_merge_commit' => false]);

        // assert
        $this->assertCount(2, $schema->property('repositories')->array());
        $this->assertEquals(true, $schema->property('repositories')->array()[0]->property('allow_merge_commit')->value());
        $this->assertEquals(false, $schema->property('repositories')->array()[1]->property('allow_merge_commit')->value());
    }

    /* @test */
    public function testArrayAttributesCanHaveSimpleChildrenSetByArray()
    {
        // setup
        $schema = $this->createSchema();

        // act
        $schema->property('events')->setValue(['push', 'pull_request']);

        // assert
        $this->assertCount(2, $schema->property('events')->array());
        $this->assertEquals('push', $schema->property('events')->array()[0]->value());
        $this->assertEquals('pull_request', $schema->property('events')->array()[1]->value());
    }

    /* @test */
    public function testArrayAttributesCanHaveComplexChildrenSetByArray()
    {
        // setup
        $schema = $this->createSchema();

        // act
        $schema->property('repositories')->setValue([['allow_merge_commit' => true], ['allow_merge_commit' => false]]);

        // assert
        $this->assertCount(2, $schema->property('repositories')->array());
        $this->assertEquals(true, $schema->property('repositories')->array()[0]->property('allow_merge_commit')->value());
        $this->assertEquals(false, $schema->property('repositories')->array()[1]->property('allow_merge_commit')->value());
    }

    /* @test */
    public function testArrayAttributesCanHaveNestedArrays()
    {
        // setup
        $schema = $this->createSchema();

        // act
        $schema->property('repositories')->setValue([
            ['topics' => ['Topic 1', 'Topic 2']],
            ['topics' => ['Topic 3', 'Topic 4']]
        ]);

        // assert
        $this->assertCount(2, $schema->property('repositories')->array());
        $this->assertCount(2, $schema->property('repositories')->array()[0]->property('topics')->value());
        $this->assertEquals('Topic 1', $schema->property('repositories')->array()[0]->property('topics')->array()[0]->value());
        $this->assertEquals('Topic 2', $schema->property('repositories')->array()[0]->property('topics')->array()[1]->value());
        $this->assertCount(2, $schema->property('repositories')->array()[1]->property('topics')->value());
        $this->assertEquals('Topic 3', $schema->property('repositories')->array()[1]->property('topics')->array()[0]->value());
        $this->assertEquals('Topic 4', $schema->property('repositories')->array()[1]->property('topics')->array()[1]->value());
    }
}
