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

use coverallskit\report\parser\LcovReportParser;
use coverallskit\report\parser\Result;


describe(LcovReportParser::class, function() {
    describe('parse', function() {
        beforeEach(function() {
            $this->sourcePath1 = $this->fixturePath('static:lcovParser:target1');
            $this->sourcePath2 = $this->fixturePath('static:lcovParser:target2');

            $fixture = $this->loadFixture('mustache:LcovParser:lcovReport', [
                'targetPath1' => $this->sourcePath1,
                'targetPath2' => $this->sourcePath2
            ]);

            $temp = $this->makeFile();
            $temp->write($fixture);

            $this->parser = new LcovReportParser();
            $this->result = $this->parser->parse( $temp->getPath() );
            $this->sources = $this->result->getSources();
        });
        it('return coverallskit\report\parser\Result', function() {
            expect($this->result)->toBeAnInstanceOf(Result::class);
        });
        describe('Result', function() {
            it('have execute line coverage', function() {
                expect($this->result->getExecutedLineCount())->toEqual(10);
            });
            it('have unused line coverage', function() {
                expect($this->result->getUnusedLineCount())->toEqual(2);
            });
            it('have parse error', function() {
                $errors = $this->result->getParseErrors();
                expect(count($errors))->toEqual(2);
            });
        });
    });
});
