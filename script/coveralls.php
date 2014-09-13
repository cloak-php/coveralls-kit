<?php

namespace coverallskit\example;

require_once __DIR__ . '/../vendor/autoload.php';

use coverallskit\Configuration;
use coverallskit\ReportBuilder;

$configration = Configuration::loadFromFile('.coveralls.yml');
$builder = ReportBuilder::fromConfiguration($configration);
//$builder->build()->save()->upload();
$builder->build()->save();
