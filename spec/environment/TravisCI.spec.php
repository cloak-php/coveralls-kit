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
use coverallskit\environment\TravisCI;


describe('TravisCI', function() {
    describe('#getName', function() {
        it('return adaptor name', function() {
            $this->travis = new TravisCI(new Environment());
            expect($this->travis->getName())->toBe('travis-ci');
        });
    });
    describe('#getBuildJobId', function() {
        it('return build job id', function() {
            $environment = new Environment([
                'TRAVIS_JOB_ID' => '10'
            ]);
            $this->travis = new TravisCI($environment);
            expect($this->travis->getBuildJobId())->toBe('10');
        });
    });
    describe('#isSupported', function() {
        context('when supported', function() {
            beforeEach(function() {
                $environment = new Environment([
                    'CI' => 'true',
                    'TRAVIS' => 'true',
                    'TRAVIS_JOB_ID' => '10',
                    'COVERALLS_REPO_TOKEN' => 'token'
                ]);
                $this->travis = new TravisCI($environment);
            });
            it('return true', function() {
                expect($this->travis->isSupported())->toBeTrue();
            });
        });
    });
});
