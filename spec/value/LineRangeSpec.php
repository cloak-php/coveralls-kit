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

use coverallskit\value\LineRange;

describe('LineRange', function() {
    describe('__construct', function() {
        context('when out of range', function() {
            it('should throw OutOfRangeException', function() {
                expect(function() {
                    new LineRange(0);
                })->toThrow('OutOfRangeException');
            });
        });
    });
    describe('contains', function() {
        before(function() {
            $this->range = new LineRange(30);
        });
        context('when the range', function() {
            it('should return true', function() {
                expect($this->range->contains(1))->toBeTrue();
                expect($this->range->contains(30))->toBeTrue();
            });
        });
        context('when out of range', function() {
            it('should return false', function() {
                expect($this->range->contains(0))->toBeFalse();
                expect($this->range->contains(31))->toBeFalse();
            });
        });
    });
});
