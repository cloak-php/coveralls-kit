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
use coverallskit\entity\collection\CoverageCollection;

describe('CoverageCollection', function() {

    describe('isEmpty', function() {
        context('when covergae empty', function() {
            it('should return true', function() {
                $coverages = new CoverageCollection(10);
                expect($coverages->isEmpty())->toBeTrue();
            });
        });
    });

    describe('add', function() {
        before(function() {
            $this->coverages = new CoverageCollection(1);
        });
        context('when the valid line number', function() {
            before(function() {
                $this->coverage = Coverage::unused(1);
                $this->coverages->add($this->coverage);
                $this->retrieveCoverage = $this->coverages->at(1);
            });
            it('should add coverage', function() {
                expect($this->coverage)->toEqual($this->retrieveCoverage);
            });
        });
        context('when the invalid line number', function() {
            before(function() {
                $this->coverage = Coverage::unused(2);
            });
            it('should throw coverallskit\exception\LineOutOfRangeException', function() {
                expect(function() {
                    $this->coverages->add($this->coverage);
                })->toThrow('coverallskit\exception\LineOutOfRangeException');
            });
        });
    });

    describe('remove', function() {
        before(function() {
            $this->coverage = Coverage::unused(1);
            $this->coverages = new CoverageCollection(1);
            $this->coverages->add($this->coverage);
        });
        it('should remove coverage', function() {
            $this->coverages->remove($this->coverage);
            expect($this->coverages->at(1))->toBeNull();
        });
    });

    describe('at', function() {
        before(function() {
            $this->coverages = new CoverageCollection(1);
        });
        context('when not found coverage', function() {
            it('should return null', function() {
                expect($this->coverages->at(1))->toBeNull();
            });
        });
    });

    describe('getExecutedLineCount', function() {
        before(function() {
            $this->coverages = new CoverageCollection(3);
            $this->coverages->add(Coverage::unused(1));
            $this->coverages->add(Coverage::executed(2));
        });
        it('return executed line count', function() {
            expect($this->coverages->getExecutedLineCount())->toEqual(1);
        });
    });

    describe('getUnusedLineCount', function() {
        before(function() {
            $this->coverages = new CoverageCollection(3);
            $this->coverages->add(Coverage::unused(1));
            $this->coverages->add(Coverage::executed(2));
        });
        it('return unused line count', function() {
            expect($this->coverages->getUnusedLineCount())->toEqual(1);
        });
    });

    describe('__toString', function() {
        before(function() {
            $this->coverages = new CoverageCollection(3);
            $this->coverages->add(Coverage::unused(1));
            $this->coverages->add(Coverage::executed(2));
        });
        it('should return coverage', function() {
            $coverage = '[0,1,null]';
            expect((string) $this->coverages)->toEqual($coverage);
        });
    });

    describe('getIterator', function() {
        before(function() {
            $this->coverage = Coverage::unused(1);
            $this->coverages = new CoverageCollection(1);
            $this->coverages->add($this->coverage);
            $this->iterator = $this->coverages->getIterator();
        });
        it('return ArrayIterator', function() {
            expect($this->iterator)->toBeAnInstanceOf('ArrayIterator');
        });
    });

});
