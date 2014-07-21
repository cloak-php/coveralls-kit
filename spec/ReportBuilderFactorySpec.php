<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\spec;

use coverallskit\ReportBuilderFactory;

describe('ReportBuilderFactory', function() {
    describe('createFromConfigurationFile', function() {
        before(function() {
            $this->factory = new ReportBuilderFactory();
            $this->builder = $this->factory->createFromConfigurationFile(__DIR__ . '/fixtures/coveralls.yml');
        });
        it('should return coverallskit\ReportBuilderInterface instance', function() {
            expect($this->builder)->toBeAnInstanceOf('\coverallskit\ReportBuilderInterface');
        });
    });
});
