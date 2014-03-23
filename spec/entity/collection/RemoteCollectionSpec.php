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

use coveralls\entity\repository\Remote;
use coveralls\entity\collection\RemoteCollection;

describe('RemoteCollection', function() {
    before(function() {
        $remote = new Remote('origin', 'https://github.com/holyshared/coveralls-kit.git');
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
});
