<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\spec;

use coverallskit\Environment;
use coverallskit\environment\DroneIO;


describe('DroneIO', function() {
    describe('#getName', function() {
        it('return adaptor name', function() {
            $this->drone = new DroneIO([]);
            expect($this->drone->getName())->toBe('drone.io');
        });
    });
    describe('#isSupported', function() {
        context('when supported', function() {
            beforeEach(function() {
                $environment = new Environment([
                    'CI' => 'true',
                    'DRONE' => 'true',
                    'DRONE_BUILD_NUMBER' => '10',
                    'COVERALLS_REPO_TOKEN' => 'token'
                ]);
                $this->drone = new DroneIO($environment);
            });
            it('return true', function() {
                expect($this->drone->isSupported())->toBeTruthy();
            });
        });
    });
});
