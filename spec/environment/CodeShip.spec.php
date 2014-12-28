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
use coverallskit\environment\CodeShip;


describe('CodeShip', function() {
    describe('#getName', function() {
        it('return adaptor name', function() {
            $this->codeship = new CodeShip(new Environment());
            expect($this->codeship->getName())->toBe('codeship');
        });
    });
    describe('#getBuildJobId', function() {
        it('return build job id', function() {
            $environment = new Environment([
                'CI_BUILD_NUMBER' => '10'
            ]);
            $this->codeship = new CodeShip($environment);
            expect($this->codeship->getBuildJobId())->toBe('10');
        });
    });
    describe('#isSupported', function() {
        context('when supported', function() {
            beforeEach(function() {
                $environment = new Environment([
                    'CI' => 'true',
                    'CI_NAME' => 'codeship',
                    'CI_BUILD_NUMBER' => '10'
                ]);
                $this->codeship = new CodeShip($environment);
            });
            it('return true', function() {
                expect($this->codeship->isSupported())->toBeTruthy();
            });
        });
    });
});
