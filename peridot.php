<?php

use Evenement\EventEmitterInterface;
use expectation\peridot\ExpectationPlugin;
use Peridot\Reporter\Dot\DotReporterPlugin;
use cloak\peridot\CloakPlugin;

return function(EventEmitterInterface $emitter)
{
    $dot = new DotReporterPlugin($emitter);
    ExpectationPlugin::create()->registerTo($emitter);

    if (defined('HHVM_VERSION') === false) {
        CloakPlugin::create('.cloak.toml')->registerTo($emitter);
    }
};
