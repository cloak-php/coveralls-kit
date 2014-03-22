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

use coveralls\exception\FileNotFoundException;

describe('FileNotFoundException', function() {
    describe('getMessage', function() {
        before(function() {
            $this->exception = new FileNotFoundException('foo.php');
        });
        it('should return message', function() {
            expect($this->exception->getMessage())->toEqual('Can not find the file foo.php');
        });
    });
});
