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
                $fixtureDirectory = __DIR__ . '/../../fixtures/';
                $sourcePath = $fixtureDirectory . 'bar.php';

                $fixture = $this->loadFixture('mustache:RecordLexer:lcovReport', [
                    'sourcePath' => realpath($sourcePath)
                ]);

                $temp = $this->makeFile();
                $temp->open();
                $temp->write($fixture);

                $this->recordLexer = new RecordLexer($temp->getPath());
            });
            it('return record stream', function() {
                $results = [];
                $records = $this->recordLexer->records();

                foreach ($records as $record) {
                    $results[] = $record;
                }
                expect(count($results))->toEqual(3);
            });
        });
    });
});
