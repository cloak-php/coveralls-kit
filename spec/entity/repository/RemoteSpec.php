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

use coverallskit\entity\repository\Remote;

describe('Remote', function() {
    before(function() {
        $this->remote = new Remote('origin', 'https://github.com/holyshared/coverallskit-kit.git');
    });
    describe('toArray', function() {
        it('should return array value', function () {
            $value = $this->remote->toArray();
            expect($value['name'])->toBe('origin');
            expect($value['url'])->toBe('https://github.com/holyshared/coverallskit-kit.git');
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
