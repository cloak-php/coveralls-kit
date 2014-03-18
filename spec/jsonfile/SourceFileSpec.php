<?php

namespace coveralls\spec;

use coveralls\jsonfile\SourceFile;
use pho;

describe('SourceFile', function() {
    before(function() {
        $this->path = __DIR__ . '/fixtures/foo.php';
        $this->sourceFile = new SourceFile($this->path);
    });
    describe('getName', function() {
        it('should return file name', function() {
            expect($this->sourceFile->getName())->toBe($this->path);
        });
    });
    describe('getContent', function() {
        it('should return file content', function() {
            expect($this->sourceFile->getContent())->toBe(file_get_contents($this->path));
        });
    });
});
