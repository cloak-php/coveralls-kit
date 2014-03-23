<?php

namespace coveralls\example;

require_once __DIR__ . '/../vendor/autoload.php';

use coveralls\JSONFileBuilder;
use coveralls\entity\service\Travis;
use coveralls\entity\Coverage;
use coveralls\entity\Repository;
use coveralls\entity\SourceFile;
use Guzzle\Http\Client;

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
$builder->token('N852hqDzBRTjy2U9hxQ0HzGblXC9ASCTQ')
    ->service(Travis::travisCI())
    ->repository(new Repository(__DIR__ . '/../'));

foreach ($result as $file => $coverage) {
    if (preg_match('/vendor/', $file) || preg_match('/spec/', $file)) {
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

    $builder->addSource($source);
}

$coverageFile = __DIR__ . '/coverage.json';

$builder->build()->saveAs($coverageFile);

$client = new Client();
$request = $client->post('https://coveralls.io/api/v1/jobs')
    ->addPostFiles(array(
        'json_file' => realpath($coverageFile)
    ));

$request->send();
