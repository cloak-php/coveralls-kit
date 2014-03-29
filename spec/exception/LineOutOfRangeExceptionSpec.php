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
use coverallskit\entity\Coverage;
use coverallskit\exception\LineOutOfRangeException;

describe('LineOutOfRangeException', function() {
    describe('getMessage', function() {
        before(function() {
            $this->exception = new LineOutOfRangeException(Coverage::unused(31), new LineRange(1, 30));
        });
        it('should return message', function() {
            $message = "The 31st line is outside the range of the 30th line from the 1st line";
            expect($this->exception->getMessage())->toEqual($message);
        });
    });
});
