<?php

namespace coveralls\spec;

use coveralls\JSONFile;
use coveralls\jsonfile\SourceFileCollection;

describe('JSONFile', function() {
    before(function() {
        $this->jsonFile = new JSONFile([
            'token' => 'foo',
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
