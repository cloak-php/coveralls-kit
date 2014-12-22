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

use coverallskit\entity\service\travis\TravisPro;
use coverallskit\Environment;

describe('TravisPro', function() {
    beforeEach(function() {
        $this->service = new TravisPro(new Environment([
            'TRAVIS_JOB_ID' => '10',
            'COVERALLS_REPO_TOKEN' => 'token'
        ]));
    });
    describe('getServiceName', function() {
        it('should return the service name', function() {
            expect($this->service->getServiceName())->toEqual('travis-pro');
        });
    });
});
