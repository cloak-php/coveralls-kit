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
use coverallskit\environment\CircleCI;


describe('CircleCI', function() {
    describe('#isSupported', function() {
        context('when supported', function() {
            beforeEach(function() {
                $environment = new Environment([
                    'CI' => 'true',
                    'CIRCLECI' => 'true',
                    'CIRCLE_BUILD_NUM' => '10',
                    'COVERALLS_REPO_TOKEN' => 'token'
                ]);
                $this->circleCI = new CircleCI($environment);
            });
            it('return true', function() {
                expect($this->circleCI->isSupported())->toBeTruthy();
            });
        });
    });
});
