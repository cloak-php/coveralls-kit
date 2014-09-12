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

describe('LcovReportParser', function() {
    describe('parse', function() {
        before(function() {
            $this->fixtureDirectory = __DIR__ . '/../../fixtures/';

            $content = file_get_contents($this->fixtureDirectory . 'report.lcov');
            $this->content = sprintf($content, getcwd(), getcwd());

            $this->parser = new LcovReportParser();
            $this->result = $this->parser->parse($this->content);
            $this->sources = $this->result->getSources();
        });
        it('return coverallskit\report\parser\Result', function() {
            expect($this->result)->toBeAnInstanceOf('coverallskit\report\parser\Result');
        });
        it('result have sources', function() {
            expect(count($this->sources))->toEqual(2);
        });
    });
});
