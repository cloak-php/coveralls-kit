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

use coverallskit\entity\collection\RemoteCollection;
use coverallskit\entity\GitRepository;
use coverallskit\entity\repository\Branch;
use coverallskit\entity\repository\Commit;

describe(GitRepository::class, function () {
    beforeEach(function () {
        $this->directory = realpath(__DIR__ . '/../../');
        $this->repository = new GitRepository($this->directory);
    });

    describe('isEmpty', function () {
        context('when repository is not empty', function () {
            it('should return false', function () {
                $repository = new GitRepository($this->directory);
                expect($repository->isEmpty())->toBeFalse();
            });
        });
    });

    describe('getCommit', function () {
        it('should return head commit', function () {
            expect($this->repository->getCommit())->toBeAnInstanceOf(Commit::class);
            expect($this->repository->getCommit()->isEmpty())->toBeFalse();
        });
    });
    describe('getBranch', function () {
        it('should return current branch', function () {
            expect($this->repository->getBranch())->toBeAnInstanceOf(Branch::class);
            expect($this->repository->getBranch()->isEmpty())->toBeFalse();
        });
    });
    describe('getRemotes', function () {
        it('should return remotes', function () {
            expect($this->repository->getRemotes())->toBeAnInstanceOf(RemoteCollection::class);
            expect($this->repository->getRemotes()->isEmpty())->toBeFalse();
        });
    });
});
