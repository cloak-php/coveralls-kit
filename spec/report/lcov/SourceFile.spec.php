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

use coverallskit\report\lcov\SourceFile;

describe(SourceFile::class, function () {
    beforeEach(function () {
        $this->fixtureDirectory = __DIR__ . '/../../fixtures/';
        $this->sourcePath = $this->fixtureDirectory . 'bar.php';
        $this->source = new SourceFile('SF:'. $this->sourcePath);
    });
    describe('getName', function () {
        it('return name', function () {
            expect($this->source->getName())->toEqual($this->sourcePath);
        });
    });
    describe('match', function () {
        context('when match', function () {
            it('return true', function () {
                expect(SourceFile::match('SF:'. $this->sourcePath))->toBeTrue();
            });
        });
        context('when unmatch', function () {
            it('return false', function () {
                expect(SourceFile::match('end_of_record'))->toBeFalse();
            });
        });
    });
});
