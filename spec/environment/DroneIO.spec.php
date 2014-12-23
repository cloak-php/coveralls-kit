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
            $this->drone = new DroneIO(new Environment());
            expect($this->drone->getName())->toBe('drone.io');
        });
    });
    describe('#getBuildJobId', function() {
        it('return build job id', function() {
            $environment = new Environment([
                'DRONE_BUILD_NUMBER' => '10'
            ]);
            $this->drone = new DroneIO($environment);
            expect($this->drone->getBuildJobId())->toBe('10');
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
