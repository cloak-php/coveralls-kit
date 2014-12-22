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

use coverallskit\exception\ExceptionCollection;
use Exception;

describe('ExceptionCollection', function() {
    beforeEach(function() {
        $this->exceptions = new ExceptionCollection();
        $this->exceptions->add(new Exception('exception'));
    });

    describe('isEmpty', function() {
        context('when empty', function() {
            beforeEach(function() {
                $this->exceptions = new ExceptionCollection();
            });
            it('return true', function() {
                expect($this->exceptions->isEmpty())->toBeTrue();
            });
        });
        context('when not empty', function() {
            beforeEach(function() {
                $this->exceptions = new ExceptionCollection();
                $this->exceptions->add(new Exception('exception'));
            });
            it('return false', function() {
                expect($this->exceptions->isEmpty())->toBeFalse();
            });
        });
    });

    describe('add', function() {
        it('add exception', function() {
            expect($this->exceptions->count())->toEqual(1);
        });
    });

    describe('merge', function() {
        beforeEach(function() {
            $exceptions = new ExceptionCollection();
            $exceptions->add(new Exception('exception'));

            $this->exceptions = new ExceptionCollection();
            $this->exceptions->merge($exceptions);
        });
        it('merge exceptions', function() {
            expect(count($this->exceptions))->toEqual(1);
        });
    });

});
