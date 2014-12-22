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
use coverallskit\entity\Coverage;
use coverallskit\entity\collection\SourceFileCollection;
use coverallskit\exception\ExceptionCollection;
use Exception;

describe('Result', function() {
    beforeEach(function() {
        $this->path = realpath(__DIR__ . '/../../fixtures/foo.php');
    });

    describe('getSources', function() {
        beforeEach(function() {
            $source = new SourceFile($this->path);
            $sources = new SourceFileCollection();
            $sources->add($source);

            $this->originalSources = $sources;

            $collection = new ExceptionCollection();
            $collection->add(new Exception('parse error'));

            $this->result = new Result($sources, $collection);
            $this->sources = $this->result->getSources();
        });
        it('return coverallskit\entity\collection\SourceFileCollection', function() {
            expect($this->sources)->toEqual($this->originalSources);
        });
    });
    describe('getExecutedLineCount', function() {
        beforeEach(function() {
            $source = new SourceFile($this->path);
            $source->addCoverage(Coverage::executed(12));

            $sources = new SourceFileCollection();
            $sources->add($source);

            $collection = new ExceptionCollection();
            $this->result = new Result($sources, $collection);
        });
        it('return executed line count', function() {
            expect($this->result->getExecutedLineCount())->toEqual(1);
        });
    });
    describe('getUnusedLineCount', function() {
        beforeEach(function() {
            $source = new SourceFile($this->path);
            $source->addCoverage(Coverage::unused(12));

            $sources = new SourceFileCollection();
            $sources->add($source);

            $collection = new ExceptionCollection();
            $this->result = new Result($sources, $collection);
        });
        it('return unused line count', function() {
            expect($this->result->getUnusedLineCount())->toEqual(1);
        });
    });
    describe('getParseErrors', function() {
        beforeEach(function() {
            $source = new SourceFile($this->path);

            $this->sources = new SourceFileCollection();
            $this->sources->add($source);

            $collection = new ExceptionCollection();
            $collection->add(new Exception('parse error'));

            $this->result = new Result($this->sources, $collection);
        });
        it('return coverallskit\exception\ExceptionCollection', function() {
            expect($this->result->getParseErrors())->toBeAnInstanceOf('coverallskit\exception\ExceptionCollection');
        });
    });
    describe('hasParseError', function() {
        beforeEach(function() {
            $source = new SourceFile($this->path);

            $this->sources = new SourceFileCollection();
            $this->sources->add($source);
        });
        context('when have parse errors', function() {
            beforeEach(function() {
                $collection = new ExceptionCollection();
                $collection->add(new Exception('parse error'));

                $this->result = new Result($this->sources, $collection);
            });

            it('return true', function() {
                expect($this->result->hasParseError())->toBeTrue();
            });
        });
        context('when have not parse errors', function() {
            beforeEach(function() {
                $collection = new ExceptionCollection();
                $this->result = new Result($this->sources, $collection);
            });
            it('return false', function() {
                expect($this->result->hasParseError())->toBeFalse();
            });
        });
    });
});
