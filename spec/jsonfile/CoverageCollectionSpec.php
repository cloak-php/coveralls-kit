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
});
