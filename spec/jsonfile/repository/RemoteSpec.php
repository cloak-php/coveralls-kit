<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coveralls\spec;

use coveralls\jsonfile\repository\Remote;

describe('Remote', function() {
    before(function() {
        $this->remote = new Remote('origin', 'https://github.com/holyshared/coveralls-kit.git');
    });
    describe('toArray', function() {
        it('should return array value', function () {
            $value = $this->remote->toArray();
            expect($value['name'])->not()->toBeNull();
            expect($value['url'])->not()->toBeNull();
        });
    });
    describe('__toString', function() {
        it('should return string value', function () {
            $expect = json_encode($this->remote->toArray());
            $value = (string) $this->remote;
            expect($value)->toEqual($expect);
        });
    });
});
