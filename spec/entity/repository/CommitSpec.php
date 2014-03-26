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

use coverallskit\entity\repository\Commit;

describe('Commit', function() {
    before(function() {
        $this->commit = new Commit(array(
            'id' => '3fdcfa494f3e9bcb17f90085af9d11a936a7ef4e',
            'authorName' => 'holyshared',
            'authorEmail' => 'holy.shared.design@gmail.com',
            'committerName' => 'holyshared',
            'committerEmail' => 'holy.shared.design@gmail.com',
            'message' => 'first commit'
        ));
    });
    describe('toArray', function() {
        it('should return head commit array value', function () {
            $values = $this->commit->toArray();
            expect($values['id'])->toBe('3fdcfa494f3e9bcb17f90085af9d11a936a7ef4e');
            expect($values['author_name'])->toBe('holyshared');
            expect($values['author_email'])->toBe('holy.shared.design@gmail.com');
            expect($values['committer_name'])->toBe('holyshared');
            expect($values['committer_email'])->toBe('holy.shared.design@gmail.com');
            expect($values['message'])->toBe('first commit');
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
