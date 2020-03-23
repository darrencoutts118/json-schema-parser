<?php

namespace JsonSchemaParser\Tests;

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
    public function testObjectPropertiesCanBeRetrivedAsAnArray()
    {
        // setup
        $schema = $this->createSchema();

        // act
        $schema->property('account')->setValue(['avatar_url' => 'https://...']);

        // assert
        $this->assertIsArray($schema->property('account')->value());
        $this->assertArrayHasKey('avatar_url', $schema->property('account')->value());
        $this->assertEquals('https://...', $schema->property('account')->value()['avatar_url']);
    }
}
