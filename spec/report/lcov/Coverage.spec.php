<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\spec\report\parser;

use coverallskit\report\lcov\Coverage;

describe(Coverage::class, function() {
    beforeEach(function() {
        $this->coverage = new Coverage('DA:1,2');
    });
    describe('getLineNumber', function() {
        it('return line number', function() {
            expect($this->coverage->getLineNumber())->toEqual(1);
        });
    });
    describe('getExecuteCount', function() {
        it('return execute count', function() {
            expect($this->coverage->getExecuteCount())->toEqual(2);
        });
    });
    describe('match', function() {
        context('when match', function() {
            it('return true', function() {
                expect(Coverage::match('DA:1,2'))->toBeTrue();
            });
        });
        context('when unmatch', function() {
            it('return false', function() {
                expect(Coverage::match('end_of_record'))->toBeFalse();
            });
        });
    });
});
