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

use coveralls\jsonfile\Repository;

describe('Repository', function() {
    before(function() {
        $this->directory = realpath(__DIR__ . '/../../');
        $this->repository = new Repository($this->directory);
    });
    describe('head', function() {
        it('should return head commit', function() {
            expect($this->repository->head)->toBeAnInstanceOf('coveralls\jsonfile\repository\Commit');
        });
    });
    describe('branch', function() {
        it('should return current branch', function() {
            expect($this->repository->branch)->toBeAnInstanceOf('coveralls\jsonfile\repository\Branch');
        });
    });
    describe('remotes', function() {
        it('should return remotes', function() {
            expect($this->repository->remotes)->toBeAnInstanceOf('coveralls\jsonfile\repository\RemoteCollection');
        });
    });
});
