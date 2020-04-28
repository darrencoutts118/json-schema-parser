<?php

namespace JsonSchemaParser\Tests;

use JsonSchemaParser\Attributes\BooleanAttribute;
use JsonSchemaParser\Attributes\NumberAttribute;
use JsonSchemaParser\Attributes\ObjectAttribute;
use JsonSchemaParser\Attributes\StringAttribute;

class PathTest extends BaseTest
{
    /* @test */
    public function testPropertiesKnowTheirOwnPath()
    {
        // setup
        $schema = $this->createSchema();

        // assert
        $this->assertEquals('account', $schema->property('account')->fqn());
        $this->assertEquals('account.avatar_url', $schema->property('account.avatar_url')->fqn());
        $this->assertEquals('repositories.owner.avatar_url', $schema->property('repositories.owner.avatar_url')->fqn());
    }
}
