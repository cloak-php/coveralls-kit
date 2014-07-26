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

use coverallskit\entity\SourceFile;
use coverallskit\entity\Coverage;

describe('SourceFile', function() {
    before(function() {
        $this->path = realpath(__DIR__ . '/../fixtures/foo.php');
        $this->relativePath = str_replace(getcwd() . '/', '', $this->path);
        $this->sourceFile = new SourceFile($this->path);
    });
    describe('__construct', function() {
        context('when the file does not exist', function() {
            it('should throw coverallskit\exception\FileNotFoundException', function() {
                expect(function() {
                    $source = new SourceFile('bar.php');
                })->toThrow('coverallskit\exception\FileNotFoundException');
            });
        });
    });
    describe('isEmpty', function() {
        context('when the contents of the source file is empty', function() {
            before(function() {
                $this->emptySourcePath = realpath(__DIR__ . '/../fixtures/empty.php');
                $this->emptySourceFile = new SourceFile($this->emptySourcePath);
            });
            it('should return true', function() {
                expect($this->emptySourceFile->isEmpty())->toBeTrue();
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
            expect($this->sourceFile->getContent())->toBe(trim(file_get_contents($this->path)));
        });
    });
    describe('getCoverages', function() {
        it('should return coverallskit\entity\collection\CoverageCollection instance', function() {
            expect($this->sourceFile->getCoverages())->toBeAnInstanceOf('coverallskit\entity\collection\CoverageCollection');
        });
    });
    describe('addCoverage', function() {
        before(function() {
            $this->coverage = Coverage::unused(1);
            $this->sourceFile->addCoverage($this->coverage);
            $this->retrieveCoverage = $this->sourceFile->getCoverage(1);
        });
        it('should add coverage', function() {
            expect($this->retrieveCoverage)->toEqual($this->coverage);
        });

        context('when line out of range', function() {
            it('should add coverage', function() {
                expect(function() {
                    $coverage = Coverage::unused(999);
                    $this->sourceFile->addCoverage($coverage);
                })->toThrow('coverallskit\exception\LineOutOfRangeException');
            });
        });
    });

    describe('removeCoverage', function() {
        before(function() {
            $this->coverage = Coverage::unused(3);
            $this->sourceFile->addCoverage($this->coverage);
        });
        it('should add coverage', function() {
            $this->sourceFile->removeCoverage($this->coverage);
            expect($this->sourceFile->getCoverage(3))->toBeNull();
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
        before(function() {
            $this->path = realpath(__DIR__ . '/../fixtures/foo.php');
            $this->relativePath = str_replace(getcwd() . '/', '', $this->path);
            $this->sourceFile = new SourceFile($this->path);
        });
        it('should return json string', function() {
            $json = [
                'name' => $this->relativePath,
                'source' => trim(file_get_contents($this->path)),
                'coverage' => [null,null,null]
            ];
            expect((string) $this->sourceFile)->toEqual(json_encode($json));
        });
    });

});
