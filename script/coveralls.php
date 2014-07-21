<?php

namespace coverallskit\example;

require_once __DIR__ . '/../vendor/autoload.php';

use coverallskit\ReportBuilder;
use coverallskit\ConfigurationLoader;
use coverallskit\entity\service\Travis;
use coverallskit\entity\Coverage;
use coverallskit\entity\Repository;
use coverallskit\entity\SourceFile;
use coverallskit\exception\LineOutOfRangeException;

/**
 * Get the code coverage
 */
xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);

$argv = array('../vendor/bin/pho');

require_once __DIR__ . "/../vendor/bin/pho";

$result = xdebug_get_code_coverage();
xdebug_stop_code_coverage();


/**
 * Generate a json file
 */
$loader = new ConfigurationLoader();
$config = $loader->loadFromFile(__DIR__ . '/../coveralls.yml');

$builder = $config->createReportBuilder();
$builder->token(getenv('COVERALLS_REPO_TOKEN'));

foreach ($result as $file => $coverage) {
    if (preg_match('/vendor/', $file) || preg_match('/spec/', $file)) {
        continue;
    }

    $source = new SourceFile($file);

    foreach ($coverage as $line => $status) {
        try {
            if ($status === 1) {
                $source->addCoverage(Coverage::executed($line));
            } else if ($status === -1) {
                $source->addCoverage(Coverage::unused($line));
            }
        } catch (LineOutOfRangeException $exception) {
            echo $source->getName() . PHP_EOL;
            echo $exception->getMessage() . PHP_EOL;
        }
    }

    $builder->addSource($source);
}

$builder->build()->save()->upload();
