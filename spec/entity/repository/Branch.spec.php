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

use coverallskit\entity\repository\Branch;

describe('Branch', function() {
    beforeEach(function() {
        $this->branch = new Branch([
            'name' => 'master',
            'remote' => false
        ]);
    });
    describe('isRemote', function() {
        context('when not remote branch', function() {
            it('should return false', function () {
                expect($this->branch->isRemote())->toBeFalse();
            });
        });
    });
    describe('__toString', function() {
        it('should return string value', function () {
            $value = (string) $this->branch;
            expect($value)->toEqual('master');
        });
    });
});
