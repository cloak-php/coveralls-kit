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
use coverallskit\entity\collection\RemoteCollection;
use ArrayIterator;


describe(RemoteCollection::class, function() {
    beforeEach(function() {
        $remote = new Remote([
            'name' => 'origin',
            'url' => 'https://github.com/holyshared/coverallskit-kit.git'
        ]);
        $this->remotes = new RemoteCollection([ $remote ]);
    });
    describe('toArray', function() {
        it('should return array value', function () {
            $value = $this->remotes->toArray();
            expect($value[0]['name'])->not()->toBeNull();
            expect($value[0]['url'])->not()->toBeNull();
        });
    });
    describe('__toString', function() {
        it('should return string value', function () {
            $expect = json_encode($this->remotes->toArray());
            $value = (string) $this->remotes;
            expect($value)->toEqual($expect);
        });
    });

    describe('getIterator', function() {
        beforeEach(function() {
            $this->iterator = $this->remotes->getIterator();
        });
        it('return ArrayIterator', function() {
            expect($this->iterator)->toBeAnInstanceOf(ArrayIterator::class);
        });
    });

});
