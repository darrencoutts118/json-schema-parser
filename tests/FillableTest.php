<?php

namespace JsonSchemaParser\Tests;

class FillableTest extends BaseTest
{
    /* @test */
    public function testASchemaCanBeFilledFromAnArray()
    {
        // setup
        $schema = $this->createSchema();

        // act
        $values = json_decode(file_get_contents(__DIR__.'/assets/example.json'));
        $schema->fill($values);

        // assert
        $expected = 'https://api.github.com/installations/1/access_tokens';
        $this->assertEquals($expected, $schema->property('access_tokens_url')->value());

        $expected = 'https://github.com/images/error/octocat_happy.gif';
        $this->assertEquals($expected, $schema->property('account.avatar_url')->value());

        $expected = ['push', 'pull_request'];
        $this->assertCount(count($expected), $schema->property('events')->value());
        $this->assertEquals($expected[0], $schema->property('events')->value()[0]->value());
        $this->assertEquals($expected[1], $schema->property('events')->value()[1]->value());

        $expected = ['octocat', 'atom', 'electron', 'api'];
        $this->assertCount(1, $schema->property('repositories')->value());
        $this->assertCount(4, $schema->property('repositories')->value()[0]->property('topics')->value());
        $this->assertEquals($expected[0], $schema->property('repositories')->value()[0]->property('topics')->value()[0]->value());
        $this->assertEquals($expected[1], $schema->property('repositories')->value()[0]->property('topics')->value()[1]->value());
        $this->assertEquals($expected[2], $schema->property('repositories')->value()[0]->property('topics')->value()[2]->value());
        $this->assertEquals($expected[3], $schema->property('repositories')->value()[0]->property('topics')->value()[3]->value());
    }

    /* @test */
    public function testASchemaCanBeFilledFromAJsonString()
    {
        // setup
        $schema = $this->createSchema();

        // act
        $values = file_get_contents(__DIR__.'/assets/example.json');
        $schema->fill($values);

        // assert
        $expected = 'https://api.github.com/installations/1/access_tokens';
        $this->assertEquals($expected, $schema->property('access_tokens_url')->value());

        $expected = 'https://github.com/images/error/octocat_happy.gif';
        $this->assertEquals($expected, $schema->property('account.avatar_url')->value());

        $expected = ['push', 'pull_request'];
        $this->assertCount(count($expected), $schema->property('events')->value());
        $this->assertEquals($expected[0], $schema->property('events')->value()[0]->value());
        $this->assertEquals($expected[1], $schema->property('events')->value()[1]->value());

        $expected = ['octocat', 'atom', 'electron', 'api'];
        $this->assertCount(1, $schema->property('repositories')->value());
        $this->assertCount(4, $schema->property('repositories')->value()[0]->property('topics')->value());
        $this->assertEquals($expected[0], $schema->property('repositories')->value()[0]->property('topics')->value()[0]->value());
        $this->assertEquals($expected[1], $schema->property('repositories')->value()[0]->property('topics')->value()[1]->value());
        $this->assertEquals($expected[2], $schema->property('repositories')->value()[0]->property('topics')->value()[2]->value());
        $this->assertEquals($expected[3], $schema->property('repositories')->value()[0]->property('topics')->value()[3]->value());
    }
}
