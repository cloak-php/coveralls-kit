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

use coverallskit\report\parser\CloverReportParser;

describe('CloverReportParser', function() {
    describe('parse', function() {
        before(function() {
            $this->fixtureDirectory = __DIR__ . '/../../fixtures/';

            $content = file_get_contents($this->fixtureDirectory . 'clover.xml');
            $this->content = sprintf($content, getcwd(), getcwd());

            $this->parser = new CloverReportParser();
            $this->result = $this->parser->parse($this->content);
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
