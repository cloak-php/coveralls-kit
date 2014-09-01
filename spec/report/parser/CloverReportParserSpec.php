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
            $this->tmpDirectory = __DIR__ . '/../../tmp/';
            $this->fixtureDirectory = __DIR__ . '/../../fixtures/';
            $this->cloverReportFile = $this->tmpDirectory . 'clover.xml';

            $content = file_get_contents($this->fixtureDirectory . 'clover.xml');
            $this->content = sprintf($content, getcwd(), getcwd());

            $this->parser = new CloverReportParser();
        });
        it('return coverallskit\report\parser\Result', function() {
            $result = $this->parser->parse($this->content);
            expect($result)->toBeAnInstanceOf('coverallskit\report\parser\Result');
        });
    });
});
