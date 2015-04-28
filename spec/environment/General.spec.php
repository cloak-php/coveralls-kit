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
use coverallskit\environment\General;


describe(General::class, function() {
    describe('#getName', function() {
        it('return adaptor name', function() {
            $this->general = new General(new Environment());
            expect($this->general->getName())->toBe('');
        });
    });
    describe('#getBuildJobId', function() {
        it('return build job id', function() {
            $environment = new Environment();
            $this->general = new General($environment);
            expect($this->general->getBuildJobId())->toBeNull();
        });
    });
    describe('#isSupported', function() {
        context('when supported', function() {
            beforeEach(function() {
                $environment = new Environment();
                $this->general = new General($environment);
            });
            it('return true', function() {
                expect($this->general->isSupported())->toBeTrue();
            });
        });
    });
});
