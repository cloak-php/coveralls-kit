<?php

namespace coveralls\example;

require_once __DIR__ . '/../vendor/autoload.php';

use coveralls\JSONFileBuilder;
use coveralls\jsonfile\Coverage;
use coveralls\jsonfile\SourceFile;


/**
 * Get the code coverage
 */
xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);

$argv = array('../vendor/bin/pho', '--reporter', 'spec');

require_once __DIR__ . "/../vendor/bin/pho";

$result = xdebug_get_code_coverage();
xdebug_stop_code_coverage();


/**
 * Generate a json file
 */
$builder = new JSONFileBuilder();
$builder->token('foo');

foreach ($result as $file => $coverage) {
    if (preg_match('/vendor/', $file) || preg_match('/spec/', $file)) {
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
$builder->build()->saveAs(__DIR__ . '/coverage.json');
