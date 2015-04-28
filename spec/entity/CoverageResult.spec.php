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
use coverallskit\entity\CoverageResult;
use UnexpectedValueException;


describe(CoverageResult::class, function() {
    describe('__construct', function() {
        context('when invalid analysis result', function() {
            it('throw UnexpectedValueException', function() {
                expect(function() {
                    new CoverageResult(1, -1);
                })->toThrow(UnexpectedValueException::class);
            });
        });
        context('when executed line', function() {
            beforeEach(function() {
                $this->coverage = new CoverageResult(100, CoverageResult::EXECUTED);
            });
            it('set line number', function() {
                expect($this->coverage->getLineNumber())->toEqual(100);
            });
            it('set analysis result', function() {
                expect($this->coverage->getAnalysisResult())->toEqual(CoverageResult::EXECUTED);
            });
        });
        context('when unused line', function() {
            beforeEach(function() {
                $this->coverage = new CoverageResult(100, CoverageResult::UNUSED);
            });
            it('set line number', function() {
                expect($this->coverage->getLineNumber())->toEqual(100);
            });
            it('set analysis result', function() {
                expect($this->coverage->getAnalysisResult())->toEqual(CoverageResult::UNUSED);
            });
        });
    });
    describe('getLineNumber', function() {
        beforeEach(function() {
            $this->coverage = new CoverageResult(1, CoverageResult::EXECUTED);
        });
        it('return line number', function() {
            expect($this->coverage->getLineNumber())->toEqual(1);
        });
    });
    describe('getAnalysisResult', function() {
        beforeEach(function() {
            $this->coverage = new CoverageResult(1, CoverageResult::EXECUTED);
        });
        it('return analysis result', function() {
            expect($this->coverage->getAnalysisResult())->toEqual(CoverageResult::EXECUTED);
        });
    });
    describe('valudOf', function() {
        beforeEach(function() {
            $this->coverage = new CoverageResult(1, CoverageResult::EXECUTED);
        });
        it('return analysis result', function() {
            expect($this->coverage->valueOf())->toEqual(CoverageResult::EXECUTED);
        });
    });
    describe('isExecuted', function() {
        context('when executed', function() {
            beforeEach(function() {
                $this->coverage = new CoverageResult(1, CoverageResult::EXECUTED);
            });
            it('return true', function() {
                expect($this->coverage->isExecuted())->toBeTrue();
            });
        });
        context('when not executed', function() {
            beforeEach(function() {
                $this->coverage = new CoverageResult(1, CoverageResult::UNUSED);
            });
            it('return false', function() {
                expect($this->coverage->isExecuted())->toBeFalse();
            });
        });
    });
    describe('isUnused', function() {
        context('when unused', function() {
            beforeEach(function() {
                $this->coverage = new CoverageResult(1, CoverageResult::UNUSED);
            });
            it('return true', function() {
                expect($this->coverage->isUnused())->toBeTrue();
            });
        });
        context('when not unused', function() {
            beforeEach(function() {
                $this->coverage = new CoverageResult(1, CoverageResult::EXECUTED);
            });
            it('return false', function() {
                expect($this->coverage->isUnused())->toBeFalse();
            });
        });
    });
    describe('contains', function() {
        beforeEach(function() {
            $this->lineRange = new LineRange(1, 100);
        });
        context('when contains line number', function() {
            beforeEach(function() {
                $this->coverage = CoverageResult::unused(100);
            });
            it('return true', function() {
                expect($this->coverage->contains($this->lineRange))->toBeTrue();
            });
        });
        context('when not contains line number', function() {
            beforeEach(function() {
                $this->coverage = CoverageResult::unused(101);
            });
            it('return false', function() {
                expect($this->coverage->contains($this->lineRange))->toBeFalse();
            });
        });
    });

    describe('unused', function() {
        beforeEach(function() {
            $this->coverage = CoverageResult::unused(1);
        });
        it('return coverallskit\entity\CoverageResult instance', function() {
            expect($this->coverage)->toBeAnInstanceOf(CoverageResult::class);
        });
        it('analysis result of return instance is unused', function() {
            expect($this->coverage->isUnused())->toBeTrue();
        });
    });
    describe('executed', function() {
        beforeEach(function() {
            $this->coverage = CoverageResult::executed(1);
        });
        it('return coverallskit\entity\CoverageResult instance', function() {
            expect($this->coverage)->toBeAnInstanceOf(CoverageResult::class);
        });
        it('analysis result of return instance is executed', function() {
            expect($this->coverage->isExecuted())->toBeTrue();
        });
    });
});
