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
use coverallskit\environment\AdaptorDetector;


describe('AdaptorDetector', function() {
    describe('#detect', function() {
        context('when supported', function() {
            beforeEach(function() {
                $environment = new Environment([
                    'CI' => 'true',
                    'CIRCLECI' => 'true',
                    'CIRCLE_BUILD_NUM' => '10',
                    'COVERALLS_REPO_TOKEN' => 'token'
                ]);
                $this->detector = new AdaptorDetector($environment);
            });
            it('return detect adaptor', function() {
                $adaptor = $this->detector->detect();
                expect($adaptor)->toBeAnInstanceOf('coverallskit\environment\CircleCI');
            });
        });
        context('when not supported', function() {
            beforeEach(function() {
                $environment = new Environment([]);
                $this->detector = new AdaptorDetector($environment);
            });
            it('throw \coverallskit\exception\EnvironmentAdaptorNotFoundException exception', function() {
                expect(function() {
                    $this->detector->detect();
                })->toThrow('\coverallskit\exception\EnvironmentAdaptorNotFoundException');
            });
        });
    });
    describe('#resolveByName', function() {
        beforeEach(function() {
            $environment = new Environment([]);
            $this->detector = new AdaptorDetector($environment);
        });
        context('when supported', function() {
            it('return detect adaptor', function() {
                $adaptor = $this->detector->resolveByName('circle-ci');
                expect($adaptor)->toBeAnInstanceOf('coverallskit\environment\CircleCI');
            });
        });
        context('when not supported', function() {
            it('throw \coverallskit\exception\EnvironmentAdaptorNotFoundException exception', function() {
                expect(function() {
                    $this->detector->resolveByName('not_found');
                })->toThrow('\coverallskit\exception\EnvironmentAdaptorNotFoundException');
            });
        });
    });
});
