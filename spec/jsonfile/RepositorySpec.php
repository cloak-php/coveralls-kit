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
        $this->repositoryDirectory = realpath(__DIR__ . '/../../');
        $this->repository = new Repository($this->repositoryDirectory);
    });
    describe('head', function() {
        it('should return head commit', function() {
            expect($this->repository->head)->toBeAnInstanceOf('Gitonomy\Git\Commit');
        });
    });
    describe('branch', function() {
        it('should return current branch', function() {
            expect($this->repository->branch)->toBeAnInstanceOf('Gitonomy\Git\Reference\Branch');
        });
    });
    describe('remotes', function() {
        it('should return remotes', function() {
            expect($this->repository->remotes)->toBeAnInstanceOf('coveralls\jsonfile\repository\RemoteCollection');
        });
    });
});
