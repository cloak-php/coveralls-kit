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

use coverallskit\entity\Coverage;

describe('Coverage', function() {
    describe('unused', function() {
        before(function() {
            $this->coverage = Coverage::unused(1);
        });
        it('should return coverallskit\entity\Coverage instance', function() {
            expect($this->coverage)->toBeAnInstanceOf('coverallskit\entity\Coverage');
            expect($this->coverage->getLineNumber())->toEqual(1);
            expect($this->coverage->isExecuted())->toBeFalse();
            expect($this->coverage->isUnused())->toBeTrue();
        });
    });
    describe('executed', function() {
        before(function() {
            $this->coverage = Coverage::executed(1);
        });
        it('should return coverallskit\entity\Coverage instance', function() {
            expect($this->coverage)->toBeAnInstanceOf('coverallskit\entity\Coverage');
            expect($this->coverage->getLineNumber())->toEqual(1);
            expect($this->coverage->isExecuted())->toBeTrue();
            expect($this->coverage->isUnused())->toBeFalse();
        });
    });
});
