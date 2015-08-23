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
use coverallskit\environment\Jenkins;

describe(Jenkins::class, function () {
    describe('#getName', function () {
        it('return adaptor name', function () {
            $this->jenkins = new Jenkins(new Environment());
            expect($this->jenkins->getName())->toBe('jenkins');
        });
    });
    describe('#getBuildJobId', function () {
        it('return build job id', function () {
            $environment = new Environment([
                'BUILD_NUMBER' => 101
            ]);
            $this->jenkins = new Jenkins($environment);
            expect($this->jenkins->getBuildJobId())->toBe(101);
        });
    });
    describe('#isSupported', function () {
        context('when jenkins enviroment', function () {
            beforeEach(function () {
                $environment = new Environment([
                    'JENKINS_URL' => 'http://example.com'
                ]);
                $this->jenkins = new Jenkins($environment);
            });
            it('return true', function () {
                expect($this->jenkins->isSupported())->toBeTrue();
            });
        });
        context('when not jenkins enviroment', function () {
            beforeEach(function () {
                $environment = new Environment();
                $this->jenkins = new Jenkins($environment);
            });
            it('return false', function () {
                expect($this->jenkins->isSupported())->toBeFalse();
            });
        });
    });
});
