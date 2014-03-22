<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coveralls\spec;

use coveralls\jsonfile\Coverage;
use coveralls\jsonfile\CoverageCollection;

describe('CoverageCollection', function() {
    describe('add', function() {
        before(function() {
            $this->coverage = Coverage::unused(1);
            $this->coverages = new CoverageCollection(1);
            $this->coverages->add($this->coverage);
            $this->retrieveCoverage = $this->coverages->at(1);
        });
        it('should add coverage', function() {
            expect($this->coverage)->toEqual($this->retrieveCoverage);
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
});
