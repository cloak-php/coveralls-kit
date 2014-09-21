<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\spec\report;

use coverallskit\report\ParserRegistry;

describe('ParserRegistry', function() {
    describe('get', function() {
        before(function() {
            $this->registry = new ParserRegistry();
            $this->parser = $this->registry->get('clover');
        });
        it('return coverallskit\report\parser\CloverReportParser instance', function() {
            expect($this->parser)->toBeAnInstanceOf('coverallskit\report\parser\CloverReportParser');
        });
    });
});
