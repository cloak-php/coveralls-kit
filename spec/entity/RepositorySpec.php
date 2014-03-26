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

use coverallskit\entity\Repository;

describe('Repository', function() {
    before(function() {
        $this->directory = realpath(__DIR__ . '/../../');
        $this->repository = new Repository($this->directory);
    });
    describe('getCommit', function() {
        it('should return head commit', function() {
            expect($this->repository->getCommit())->toBeAnInstanceOf('coverallskit\entity\repository\Commit');
            expect($this->repository->getCommit()->isEmpty())->toBeFalse();
        });
    });
    describe('getBranch', function() {
        it('should return current branch', function() {
            expect($this->repository->getBranch())->toBeAnInstanceOf('coverallskit\entity\repository\Branch');
            expect($this->repository->getBranch()->isEmpty())->toBeFalse();
        });
    });
    describe('getRemotes', function() {
        it('should return remotes', function() {
            expect($this->repository->getRemotes())->toBeAnInstanceOf('coverallskit\entity\collection\RemoteCollection');
            expect($this->repository->getRemotes()->isEmpty())->toBeFalse();
        });
    });
});
