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
use coverallskit\entity\collection\SourceFileCollection;

describe('SourceFileCollection', function() {
    before(function() {
        $this->path = realpath(__DIR__ . '/../../fixtures/foo.php');
        $this->relativePath = str_replace(getcwd() . '/', '', $this->path);
        $this->source = [
            'name' => $this->relativePath,
            'source' => trim(file_get_contents($this->path)),
            'coverage' => [null,null,null]
        ];
        $this->values = [ $this->source ];

        $this->source = new SourceFile($this->path);
        $this->sources = new SourceFileCollection();
        $this->sources->add( $this->source );
    });

    describe('isEmpty', function() {
        context('when the source files is empty', function() {
            before(function() {
                $this->emptySources = new SourceFileCollection();
            });
            it('should return true', function() {
                expect($this->emptySources->isEmpty())->toBeTrue();
            });
        });
    });

    describe('has', function() {
        context('when file exists', function() {
            it('should return true', function() {
                expect($this->sources->has($this->path))->toBeTrue();
            });
        });
    });
    describe('toArray', function() {
        it('should return array value', function() {
            expect($this->sources->toArray())->toEqual($this->values);
        });
    });
    describe('__toString', function() {
        it('should return json string', function() {
            expect((string) $this->sources)->toEqual(json_encode($this->values));
        });
    });
});
