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

use coveralls\jsonfile\repository\Commit;
use Gitonomy\Git\Commit as HeadCommit;
use Gitonomy\Git\Repository as GitRepository;

describe('Commit', function() {
    before(function() {
        $repository = new GitRepository(realpath(__DIR__ . '/../../../'));
        $headCommit = new HeadCommit($repository, '81a5e4dfaf9c1f34117ac9cdc3ee8fb477c3f6c5');
        $this->commit = new Commit($headCommit);
    });
    describe('toArray', function() {
        it('should return head commit array value', function () {
            $values = $this->commit->toArray();
            expect($values['id'])->not()->toBeNull();
            expect($values['author_name'])->not()->toBeNull();
            expect($values['author_email'])->not()->toBeNull();
            expect($values['committer_name'])->not()->toBeNull();
            expect($values['committer_email'])->not()->toBeNull();
            expect($values['message'])->not()->toBeNull();
        });
    });
    describe('__toString', function() {
        it('should return string value', function () {
            $json = json_encode($this->commit->toArray());
            $value = (string) $this->commit;
            expect($value)->toBe($json);
        });
    });
});
