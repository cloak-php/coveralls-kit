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

    describe('records', function() {
        context('when have unsupport recover type', function() {
            beforeEach(function() {
                $this->fixtureDirectory = __DIR__ . '/../../fixtures/';
                $this->sourcePath = $this->fixtureDirectory . 'bar.php';

                $fixture = $this->loadFixture('mustache:RecordLexer:lcovReport', [
                    'sourcePath' => realpath($this->sourcePath)
                ]);
                $lcovReport = sys_get_temp_dir() . '/test.lcov';
                file_put_contents($lcovReport, $fixture);

                $this->recordLexer = new RecordLexer($lcovReport);

                $results = [];
                $records = $this->recordLexer->records();

                foreach ($records as $record) {
                    $results[] = $record;
                }
                $this->results = $results;
            });
            it('return record stream', function() {
                expect(count($this->results))->toEqual(3);
            });
        });
    });
});
