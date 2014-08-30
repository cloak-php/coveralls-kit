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
            //$content = file_get_contents(__DIR__ . '/../../fixtures/clover.xml');

            $this->parser = new CloverReportParser(__DIR__ . '/../../fixtures/clover.xml');
        });
        it('return source files result', function() {
            $result = $this->parser->parse();
            expect($result)->toBeAnInstanceOf('coverallskit\entity\collection\SourceFileCollection');
        });
    });
});
