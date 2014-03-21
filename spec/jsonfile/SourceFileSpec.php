<?php

namespace coveralls\spec;

use coveralls\jsonfile\SourceFile;
use coveralls\jsonfile\CoverageCollection;
use coveralls\exception\FileNotFoundException;

describe('SourceFile', function() {
    before(function() {
        $this->path = __DIR__ . '/fixtures/foo.php';
        $this->sourceFile = new SourceFile($this->path);
    });
    describe('__construct', function() {
        context('when the file does not exist', function() {
            it('should throw coveralls\exception\FileNotFoundException', function() {
                expect(function() {
                    $source = new SourceFile('bar.php');
                })->toThrow('coveralls\exception\FileNotFoundException');
            });
        });
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
    describe('getCoverages', function() {
        it('should return coveralls\jsonfile\CoverageCollection instance', function() {
            expect($this->sourceFile->getCoverages())->toBeAnInstanceOf('coveralls\jsonfile\CoverageCollection');
        });
    });

    describe('toArray', function() {
        it('should return array values', function() {
            $values = $this->sourceFile->toArray();
            expect($values['name'])->toEqual($this->sourceFile->getName());
            expect($values['content'])->toEqual($this->sourceFile->getContent());
            expect($values['coverage'])->toEqual($this->sourceFile->getCoverages()->toArray());
        });
    });

});
