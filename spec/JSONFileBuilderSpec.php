<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coveralls\spec;

use coveralls\JSONFileBuilder;
use coveralls\jsonfile\SourceFile;
use coveralls\environment\TravisCI;

describe('JSONFileBuilder', function() {
    before(function() {
        $this->foo = realpath(__DIR__ . '/jsonfile/fixtures/foo.php');
        $this->bar = realpath(__DIR__ . '/jsonfile/fixtures/bar.php');
        $this->builder = new JSONFileBuilder();
        $this->builder->token('foo');
//        $this->builder->environment(new TravisCI());
        $this->builder->addSource(new SourceFile($this->foo));
        $this->builder->addSource(new SourceFile($this->bar));
        $this->jsonFile = $this->builder->build();
    });
    describe('token', function() {
        it('should set the repository token', function() {
            expect($this->jsonFile->token)->toBe('foo');
        });
    });
    describe('addSource', function() {
        it('should add the source file', function() {
            expect($this->jsonFile->sourceFiles->has($this->foo))->toBeTrue();
            expect($this->jsonFile->sourceFiles->has($this->bar))->toBeTrue();
        });
    });
});
