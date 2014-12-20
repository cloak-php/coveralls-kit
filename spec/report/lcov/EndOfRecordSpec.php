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

use coverallskit\report\lcov\EndOfRecord;

describe('EndOfRecord', function() {
    beforeEach(function() {
        $this->endOfRecord = new EndOfRecord();
    });
    describe('match', function() {
        context('when match', function() {
            it('return true', function() {
                expect(EndOfRecord::match('end_of_record'))->toBeTrue();
            });
        });
        context('when unmatch', function() {
            it('return false', function() {
                expect(EndOfRecord::match('DA:1,2'))->toBeFalse();
            });
        });
    });
});
