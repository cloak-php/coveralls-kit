<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coveralls\spec;

use coveralls\entity\SourceFile;
use coveralls\entity\collection\CoverageCollection;
use coveralls\exception\FileNotFoundException;

describe('SourceFile', function() {
    before(function() {
        $this->path = __DIR__ . '/fixtures/foo.php';
        $this->relativePath = str_replace(getcwd(), '', $this->path);
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
        it('should return coveralls\entity\collection\CoverageCollection instance', function() {
            expect($this->sourceFile->getCoverages())->toBeAnInstanceOf('coveralls\entity\collection\CoverageCollection');
        });
    });
    describe('toArray', function() {
        it('should return array values', function() {
            $values = $this->sourceFile->toArray();
            expect($values['name'])->toEqual($this->sourceFile->getPathFromCurrentDirectory());
            expect($values['source'])->toEqual($this->sourceFile->getContent());
            expect($values['coverage'])->toEqual($this->sourceFile->getCoverages()->toArray());
        });
    });
    describe('__toString', function() {
        it('should return json string', function() {
            $json = [
                'name' => $this->relativePath,
                'source' => file_get_contents($this->path),
                'coverage' => [null,null,null,null]
            ];
            expect((string) $this->sourceFile)->toEqual(json_encode($json));
        });
    });

});
