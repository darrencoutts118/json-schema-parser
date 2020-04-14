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
        $values = json_decode(file_get_contents(__DIR__ . '/assets/example.json'));
        $schema->fill($values);

        // assert
        $expected = 'https://api.github.com/installations/1/access_tokens';
        $this->assertEquals($expected, $schema->property('access_tokens_url')->value());

        $expected = 'https://github.com/images/error/octocat_happy.gif';
        $this->assertEquals($expected, $schema->property('account.avatar_url')->value());

        $expected = ['push', 'pull_request'];
        $this->assertCount(count($expected), $schema->property('events')->value());
        $this->assertEquals($expected[0], $schema->property('events')->array()[0]->value());
        $this->assertEquals($expected[1], $schema->property('events')->array()[1]->value());

        $expected = ['octocat', 'atom', 'electron', 'api'];
        $actual = $schema->property('repositories')->array()[0]->property('topics')->array();
        $this->assertCount(1, $schema->property('repositories')->array());
        $this->assertCount(4, $schema->property('repositories')->array()[0]->property('topics')->array());
        $this->assertEquals($expected[0], $actual[0]->value());
        $this->assertEquals($expected[1], $actual[1]->value());
        $this->assertEquals($expected[2], $actual[2]->value());
        $this->assertEquals($expected[3], $actual[3]->value());
    }

    /* @test */
    public function testASchemaCanBeFilledFromAJsonString()
    {
        // setup
        $schema = $this->createSchema();

        // act
        $values = file_get_contents(__DIR__ . '/assets/example.json');
        $schema->fill($values);

        // assert
        $expected = 'https://api.github.com/installations/1/access_tokens';
        $this->assertEquals($expected, $schema->property('access_tokens_url')->value());

        $expected = 'https://github.com/images/error/octocat_happy.gif';
        $this->assertEquals($expected, $schema->property('account.avatar_url')->value());

        $expected = ['push', 'pull_request'];
        $this->assertCount(count($expected), $schema->property('events')->value());
        $this->assertEquals($expected[0], $schema->property('events')->array()[0]->value());
        $this->assertEquals($expected[1], $schema->property('events')->array()[1]->value());

        $expected = ['octocat', 'atom', 'electron', 'api'];
        $actual = $schema->property('repositories')->array()[0]->property('topics')->array();
        $this->assertCount(1, $schema->property('repositories')->array());
        $this->assertCount(4, $schema->property('repositories')->array()[0]->property('topics')->array());
        $this->assertEquals($expected[0], $actual[0]->value());
        $this->assertEquals($expected[1], $actual[1]->value());
        $this->assertEquals($expected[2], $actual[2]->value());
        $this->assertEquals($expected[3], $actual[3]->value());
    }
}
