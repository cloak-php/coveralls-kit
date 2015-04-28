<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\spec\report\parser;

use coverallskit\report\lcov\RecordLexer;

describe(RecordLexer::class, function() {
    describe('getIterator', function() {
        context('when have unsupport recover type', function() {
            beforeEach(function() {
                $this->fixtureDirectory = __DIR__ . '/../../fixtures/';
                $this->sourcePath = $this->fixtureDirectory . 'bar.php';

                $records = [
                    "TN:test",
                    "SF:" . $this->sourcePath,
                    "DA:1,1",
                    "end_of_record",
                ];
                $content = join(PHP_EOL, $records) . PHP_EOL;
                $this->recordLexer = new RecordLexer($content);
                $this->records = $this->recordLexer->getIterator();
            });
            it('return ArrayIterator', function() {
                expect(count($this->records))->toEqual(3);
            });
        });
    });
});
