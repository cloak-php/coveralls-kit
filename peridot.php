<?php

use Evenement\EventEmitterInterface;
use expect\peridot\ExpectPlugin;
use cloak\peridot\CloakPlugin;
use Peridot\Reporter\Dot\DotReporterPlugin;
use holyshared\fixture\peridot\FileFixturePlugin;

return function(EventEmitterInterface $emitter)
{
    $dot = new DotReporterPlugin($emitter);
    ExpectPlugin::create()->registerTo($emitter);

    $fixturePlugin = new FileFixturePlugin(__DIR__ . '/spec/fixtures/.fixtures.toml');
    $fixturePlugin->registerTo($emitter);

    if (defined('HHVM_VERSION') === false) {
        CloakPlugin::create('.cloak.toml')->registerTo($emitter);
    }
};
