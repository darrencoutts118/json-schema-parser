<?php

include __DIR__.'/vendor/autoload.php';

use JsonSchemaParser\Schema;

$json = file_get_contents(__DIR__.'/tests/assets/schema.json');
$schema = new Schema($json);

// act
$schema->property('repositories')->setValue([['allow_merge_commit' => true], ['allow_merge_commit' => false]]);

dump($schema);
