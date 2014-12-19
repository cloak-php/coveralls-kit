<?php

namespace coverallskit\example;

require_once __DIR__ . '/../vendor/autoload.php';


use cloak\Analyzer;
use cloak\configuration\ConfigurationLoader;

$loader = new ConfigurationLoader();
$configuration = $loader->loadConfiguration('cloak.toml');

$analyzer = new Analyzer($configuration);
$analyzer->start();

$argv = ['../vendor/bin/pho', '--stop'];
require_once __DIR__ . "/../vendor/bin/pho";

$analyzer->stop();
