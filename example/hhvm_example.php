<?php

namespace coverallskit\example;

require_once __DIR__ . '/../vendor/autoload.php';

use coverallskit\CoverallsReportBuilder;
use coverallskit\entity\CIService;
use coverallskit\entity\CoverageResult;
use coverallskit\entity\GitRepository;
use coverallskit\entity\SourceFile;
use coverallskit\Environment;
use coverallskit\environment\TravisCI;

/*
 * Get the code coverage
 */
fb_enable_code_coverage();

require_once __DIR__ . '/basic/example.php';

$result = fb_get_code_coverage(true);
fb_disable_code_coverage();

/*
 * Generate a json file
 */
$travis = new TravisCI(new Environment($_SERVER));
$service = new CIService($travis);

$builder = new CoverallsReportBuilder();
$builder->token('foo')
    ->service($service)
    ->repository(new GitRepository(__DIR__ . '/../'));

foreach ($result as $file => $coverage) {
    if (preg_match('/vendor/', $file) || preg_match('/src/', $file)) {
        continue;
    }

    $source = new SourceFile($file);

    foreach ($coverage as $line => $status) {
        if ($status === 1) {
            $source->addCoverage(CoverageResult::executed($line));
        } elseif ($status === -1) {
            $source->addCoverage(CoverageResult::unused($line));
        }
    }

    $builder->addSource($source);
}

$builder->build()->saveAs(__DIR__ . '/tmp/hhvm_coverage.json');
