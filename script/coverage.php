<?php

namespace coverallskit\example;

require_once __DIR__ . '/../vendor/autoload.php';

use PHP_CodeCoverage;
use PHP_CodeCoverage_Report_Clover;
use PHP_CodeCoverage_Filter;

$filter = new PHP_CodeCoverage_Filter();
$filter->addDirectoryToWhitelist('src');

$coverage = new PHP_CodeCoverage(null, $filter);
$reporter = new PHP_CodeCoverage_Report_Clover();

$coverage->start('default');

$argv = ['../vendor/bin/pho', '--stop'];
require_once __DIR__ . "/../vendor/bin/pho";

$coverage->stop();

$reporter->process($coverage, 'script/clover.xml');
