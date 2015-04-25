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
use Prophecy\Prophet;

describe('LineRange', function() {
    describe('__construct', function() {
        context('when out of range', function() {
            it('should throw OutOfRangeException', function() {
                expect(function() {
                    new LineRange(1, 0);
                })->toThrow('OutOfRangeException');
                expect(function() {
                    new LineRange(0, 1);
                })->toThrow('OutOfRangeException');
            });
        });
        context('when range specified is wrong', function() {
            it('should throw OutOfRangeException', function() {
                expect(function() {
                    new LineRange(5, 1);
                })->toThrow('OutOfRangeException');
            });
        });
    });
    describe('contains', function() {
        beforeEach(function() {
            $this->range = new LineRange(1, 30);
        });
        context('when the specified line number', function() {
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
        context('when the specified CoverageInterface', function() {
            beforeEach(function() {
                $this->prophet = new Prophet();
            });
            afterEach(function() {
                $this->prophet->checkPredictions();
            });
            context('when the range', function() {
                beforeEach(function() {
                    $this->mixCovergage = $this->prophet->prophesize('coverallskit\entity\CoverageEntity');
                    $this->mixCovergage->getLineNumber()->willReturn(1);

                    $this->maxCovergage = $this->prophet->prophesize('coverallskit\entity\CoverageEntity');
                    $this->maxCovergage->getLineNumber()->willReturn(30);

                    $this->min = $this->mixCovergage->reveal();
                    $this->max = $this->maxCovergage->reveal();
                });
                it('should return true', function() {
                    expect($this->range->contains($this->min))->toBeTrue();
                    expect($this->range->contains($this->max))->toBeTrue();
                });
            });
            context('when out of range', function() {
                beforeEach(function() {
                    $this->mixCovergage = $this->prophet->prophesize('coverallskit\entity\CoverageEntity');
                    $this->mixCovergage->getLineNumber()->willReturn(0);

                    $this->maxCovergage = $this->prophet->prophesize('coverallskit\entity\CoverageEntity');
                    $this->maxCovergage->getLineNumber()->willReturn(31);

                    $this->min = $this->mixCovergage->reveal();
                    $this->max = $this->maxCovergage->reveal();
                });
                it('should return false', function() {
                    expect($this->range->contains($this->min))->toBeFalse();
                    expect($this->range->contains($this->max))->toBeFalse();
                });
            });
        });
    });
});
