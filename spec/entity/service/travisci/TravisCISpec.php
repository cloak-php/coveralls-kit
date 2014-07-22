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

use coverallskit\entity\service\travisci\TravisCI;
use coverallskit\Environment;

describe('TravisCI', function() {
    before(function() {
        $this->service = new TravisCI(new Environment([
            'TRAVIS_JOB_ID' => '10',
            'COVERALLS_REPO_TOKEN' => 'token'
        ]));
    });
    describe('isEmpty', function() {
        it('should return false', function () {
            expect($this->service->isEmpty())->toBeFalse();
        });
    });
    describe('getServiceName', function() {
        it('should return the service name', function() {
            expect($this->service->getServiceName())->toEqual('travis-ci');
        });
    });
});
