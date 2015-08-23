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

use coverallskit\entity\CoverageResult;
use coverallskit\exception\LineOutOfRangeException;
use coverallskit\value\LineRange;

describe(LineOutOfRangeException::class, function () {
    describe('getMessage', function () {
        beforeEach(function () {
            $this->exception = new LineOutOfRangeException(CoverageResult::unused(31), new LineRange(1, 30));
        });
        it('should return message', function () {
            $message = "The 31st line is outside the range of the 30th line from the 1st line";
            expect($this->exception->getMessage())->toEqual($message);
        });
    });
});
