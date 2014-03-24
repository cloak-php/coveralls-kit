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

use coveralls\jsonfile\repository\Branch;
use Gitonomy\Git\Reference\Branch as CommitBranch;
use Gitonomy\Git\Repository as GitRepository;

describe('Branch', function() {
    before(function() {
        $repository = new GitRepository(realpath(__DIR__ . '/../../../'));
        $branch = new CommitBranch($repository, 'refs/heads/master', '81a5e4dfaf9c1f34117ac9cdc3ee8fb477c3f6c5');
        $this->branch = new Branch($branch);
    });
    describe('__toString', function() {
        it('should return string value', function () {
            $value = (string) $this->branch;
            expect($value)->toEqual('master');
        });
    });
});
