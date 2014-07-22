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

use coverallskit\Env;

describe('Env', function() {
    before(function() {
        $this->env = new Env([
            'foo' => 'bar'
        ]);
    });
    describe('get', function() {
        context('when have key', function() {
            it('should return value', function() {
                expect($this->env->get('foo'))->toEqual('bar');
            });
        });
        context('when have not key', function() {
            it('should return null', function() {
                expect($this->env->get('bar'))->toBeNull();
            });
        });
    });
});
