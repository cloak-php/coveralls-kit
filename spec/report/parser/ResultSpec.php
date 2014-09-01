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

use coverallskit\report\parser\Result;
use coverallskit\entity\SourceFile;
use coverallskit\entity\collection\SourceFileCollection;

describe('Result', function() {
    describe('getSources', function() {
        before(function() {
            $this->path = realpath(__DIR__ . '/../../fixtures/foo.php');

            $source = new SourceFile($this->path);
            $sources = new SourceFileCollection();
            $sources->add($source);

            $this->originalSources = $sources;

            $this->result = new Result($sources, []);
            $this->sources = $this->result->getSources();
        });
        it('return coverallskit\entity\collection\SourceFileCollection', function() {
            expect($this->sources)->toEqual($this->originalSources);
        });
    });
});
