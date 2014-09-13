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
use Guzzle\Tests\Http\Exception\ExceptionTest;

describe('LcovReportParser', function() {
    describe('parse', function() {
        before(function() {
            try {
            $this->fixtureDirectory = __DIR__ . '/../../fixtures/';
            $this->sourcePath1 = $this->fixtureDirectory . 'bar.php';
            $this->sourcePath2 = $this->fixtureDirectory . 'foo.php';

            $content = file_get_contents($this->fixtureDirectory . 'report.lcov');
            $this->content = sprintf($content, getcwd(), getcwd());

            $this->parser = new LcovReportParser();
            $this->result = $this->parser->parse($this->content);
            $this->sources = $this->result->getSources();
        } catch (\Exception $e) {
var_dump($e);
        }


        });
        it('return coverallskit\report\parser\Result', function() {
            expect($this->result)->toBeAnInstanceOf('coverallskit\report\parser\Result');
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
