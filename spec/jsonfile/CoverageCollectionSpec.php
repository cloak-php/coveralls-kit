<?php

namespace coveralls\spec;

use coveralls\jsonfile\Coverage;
use coveralls\jsonfile\CoverageCollection;

describe('CoverageCollection', function() {
    describe('add', function() {
        before(function() {
            $this->coverages = new CoverageCollection();
        });
        it('should add coverage', function() {
            $coverage = Coverage::unused(1);
            $this->coverages->add($coverage);
            $retrieveCoverage = $this->coverages->at(1);
            expect($coverage)->toEqual($retrieveCoverage);
        });
    });
});
