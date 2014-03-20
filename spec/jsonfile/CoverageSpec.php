<?php

namespace coveralls\spec;

use coveralls\jsonfile\Coverage;

describe('Coverage', function() {
    describe('unused', function() {
        before(function() {
            $this->coverage = Coverage::unused(1);
        });
        it('should return coveralls\jsonfile\Coverage instance', function() {
            expect($this->coverage)->toBeAnInstanceOf('coveralls\jsonfile\Coverage');
            expect($this->coverage->getLineNumber())->toEqual(1);
            expect($this->coverage->getAnalysisResult())->toEqual(Coverage::UNUSED);
        });
    });
    describe('executed', function() {
        before(function() {
            $this->coverage = Coverage::executed(1);
        });
        it('should return coveralls\jsonfile\Coverage instance', function() {
            expect($this->coverage)->toBeAnInstanceOf('coveralls\jsonfile\Coverage');
            expect($this->coverage->getLineNumber())->toEqual(1);
            expect($this->coverage->getAnalysisResult())->toEqual(Coverage::EXECUTED);
        });
    });
});
