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
use coverallskit\entity\Coverage;

describe('Coverage', function() {
    describe('__construct', function() {
        context('when invalid analysis result', function() {
            it('throw UnexpectedValueException', function() {
                expect(function() {
                    new Coverage(1, -1);
                })->toThrow('UnexpectedValueException');
            });
        });
        context('when executed line', function() {
            before(function() {
                $this->coverage = new Coverage(100, Coverage::EXECUTED);
            });
            it('set line number', function() {
                expect($this->coverage->getLineNumber())->toEqual(100);
            });
            it('set analysis result', function() {
                expect($this->coverage->getAnalysisResult())->toEqual(Coverage::EXECUTED);
            });
        });
        context('when unused line', function() {
            before(function() {
                $this->coverage = new Coverage(100, Coverage::UNUSED);
            });
            it('set line number', function() {
                expect($this->coverage->getLineNumber())->toEqual(100);
            });
            it('set analysis result', function() {
                expect($this->coverage->getAnalysisResult())->toEqual(Coverage::UNUSED);
            });
        });
    });
    describe('getLineNumber', function() {
        before(function() {
            $this->coverage = new Coverage(1, Coverage::EXECUTED);
        });
        it('return line number', function() {
            expect($this->coverage->getLineNumber())->toEqual(1);
        });
    });
    describe('getAnalysisResult', function() {
        before(function() {
            $this->coverage = new Coverage(1, Coverage::EXECUTED);
        });
        it('return analysis result', function() {
            expect($this->coverage->getAnalysisResult())->toEqual(Coverage::EXECUTED);
        });
    });
    describe('isExecuted', function() {
        context('when executed', function() {
            before(function() {
                $this->coverage = new Coverage(1, Coverage::EXECUTED);
            });
            it('return true', function() {
                expect($this->coverage->isExecuted())->toBeTrue();
            });
        });
        context('when not executed', function() {
            before(function() {
                $this->coverage = new Coverage(1, Coverage::UNUSED);
            });
            it('return false', function() {
                expect($this->coverage->isExecuted())->toBeFalse();
            });
        });
    });
    describe('isUnused', function() {
        context('when unused', function() {
            before(function() {
                $this->coverage = new Coverage(1, Coverage::UNUSED);
            });
            it('return true', function() {
                expect($this->coverage->isUnused())->toBeTrue();
            });
        });
        context('when not unused', function() {
            before(function() {
                $this->coverage = new Coverage(1, Coverage::EXECUTED);
            });
            it('return false', function() {
                expect($this->coverage->isUnused())->toBeFalse();
            });
        });
    });
    describe('contains', function() {
        before(function() {
            $this->lineRange = new LineRange(1, 100);
        });
        context('when contains line number', function() {
            before(function() {
                $this->coverage = Coverage::unused(100);
            });
            it('return true', function() {
                expect($this->coverage->contains($this->lineRange))->toBeTrue();
            });
        });
        context('when not contains line number', function() {
            before(function() {
                $this->coverage = Coverage::unused(101);
            });
            it('return false', function() {
                expect($this->coverage->contains($this->lineRange))->toBeFalse();
            });
        });
    });

    describe('unused', function() {
        before(function() {
            $this->coverage = Coverage::unused(1);
        });
        it('return coverallskit\entity\Coverage instance', function() {
            expect($this->coverage)->toBeAnInstanceOf('coverallskit\entity\Coverage');
        });
        it('analysis result of return instance is unused', function() {
            expect($this->coverage->isUnused())->toBeTrue();
        });
    });
    describe('executed', function() {
        before(function() {
            $this->coverage = Coverage::executed(1);
        });
        it('return coverallskit\entity\Coverage instance', function() {
            expect($this->coverage)->toBeAnInstanceOf('coverallskit\entity\Coverage');
        });
        it('analysis result of return instance is executed', function() {
            expect($this->coverage->isExecuted())->toBeTrue();
        });
    });
});
