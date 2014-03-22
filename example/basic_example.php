<?php

namespace coveralls\example;

require_once __DIR__ . '/../vendor/autoload.php';

use coveralls\JSONFileBuilder;
use coveralls\service\TravisCI;
use coveralls\jsonfile\Coverage;
use coveralls\jsonfile\SourceFile;

/**
 * Get the code coverage
 */
xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);

require_once __DIR__ . '/basic/example.php';

$result = xdebug_get_code_coverage();
xdebug_stop_code_coverage();


/**
 * Generate a json file
 */
$builder = new JSONFileBuilder();
$builder->token('foo')->service(TravisCI::ci());

foreach ($result as $file => $coverage) {
    if (preg_match('/vendor/', $file) || preg_match('/src/', $file)) {
        continue;
    }

    $source = new SourceFile($file);
    $coverages = $source->getCoverages();

    foreach ($coverage as $line => $status) {
        if ($status === 1) {
            $coverages->add(Coverage::executed(1));
        } else if ($status === -1) {
            $coverages->add(Coverage::unused(1));
        }
    }
}

$builder->addSource($source);
$builder->build()->saveAs(__DIR__ . '/tmp/coverage.json');
