<?php

namespace coveralls\spec;

use coveralls\jsonfile\Coverage;
use coveralls\jsonfile\CoverageCollection;

describe('CoverageCollection', function() {
    describe('add', function() {
        before(function() {
            $this->coverage = Coverage::unused(1);
            $this->coverages = new CoverageCollection();
            $this->coverages->add($this->coverage);
            $this->retrieveCoverage = $this->coverages->at(1);
        });
        it('should add coverage', function() {
            expect($this->coverage)->toEqual($this->retrieveCoverage);
        });
    });
    describe('at', function() {
        before(function() {
            $this->coverages = new CoverageCollection();
        });
        context('when not found coverage', function() {
            it('should return null', function() {
                expect($this->coverages->at(1))->toBeNull();
            });
        });
    });
});
