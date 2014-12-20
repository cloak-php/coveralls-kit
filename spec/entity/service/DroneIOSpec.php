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
use coverallskit\entity\service\DroneIO;


describe('DroneIO', function() {
    beforeEach(function() {
        $environment = new Environment([
            'DRONE_BUILD_NUMBER' => '10',
            'COVERALLS_REPO_TOKEN' => 'token'
        ]);
        $this->service = new DroneIO($environment);
    });
    describe('getServiceJobId', function() {
        it('should return the service job id', function() {
            expect($this->service->getServiceJobId())->toEqual('10');
        });
    });
    describe('getServiceName', function() {
        it('should return the service name', function() {
            expect($this->service->getServiceName())->toEqual('drone.io');
        });
    });
});
