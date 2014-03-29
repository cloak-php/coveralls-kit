<?php

namespace coverallskit\example;

require_once __DIR__ . '/../vendor/autoload.php';

use coverallskit\JSONFileBuilder;
use coverallskit\entity\service\Travis;
use coverallskit\entity\Repository;
use coverallskit\entity\Coverage;
use coverallskit\entity\SourceFile;

/**
 * Get the code coverage
 */
fb_enable_code_coverage();

require_once __DIR__ . '/basic/example.php';

$result = fb_get_code_coverage(true);
fb_disable_code_coverage();


/**
 * Generate a json file
 */
$builder = new JSONFileBuilder();
$builder->token('foo')
    ->service(Travis::travisCI())
    ->repository(new Repository(__DIR__ . '/../'));

foreach ($result as $file => $coverage) {
    if (preg_match('/vendor/', $file) || preg_match('/src/', $file)) {
        continue;
    }

    $source = new SourceFile($file);

    foreach ($coverage as $line => $status) {
        if ($status === 1) {
            $source->addCoverage(Coverage::executed($line));
        } else if ($status === -1) {
            $source->addCoverage(Coverage::unused($line));
        }
    }
}

$builder->addSource($source);
$builder->build()->saveAs(__DIR__ . '/tmp/hhvm_coverage.json');

