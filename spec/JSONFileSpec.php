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

use coveralls\JSONFile;
use coveralls\jsonfile\SourceFileCollection;
use coveralls\environment\TravisCI;

describe('JSONFile', function() {
    before(function() {
        $this->jsonFile = new JSONFile([
            'token' => 'foo',
            'environment' => TravisCI::ci(),
            'sourceFiles' => new SourceFileCollection()
        ]);
    });
    describe('token', function() {
        it('should return repository token string', function() {
            expect($this->jsonFile->token)->toBe('foo');
        });
    });
    describe('sourceFiles', function() {
        it('should return sources file collection', function() {
            expect($this->jsonFile->sourceFiles)->toBeAnInstanceOf('coveralls\jsonfile\SourceFileCollection');
        });
    });
    describe('saveAs', function() {
        before(function() {
            mkdir(__DIR__ . '/tmp');
            $this->path = __DIR__ . '/tmp/coverage.json';
            $this->jsonFile->saveAs($this->path);
        });
        after(function() {
            unlink($this->path);
            rmdir(__DIR__ . '/tmp');
        });
        it('should saved the file', function() {
            expect(file_exists($this->path))->toBeTrue();
        });
    });
});
