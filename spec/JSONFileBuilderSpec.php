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

use coveralls\JSONFileBuilder;
use coveralls\jsonfile\SourceFile;
use coveralls\service\TravisCI;
use Prophecy\Prophet;

describe('JSONFileBuilder', function() {
    describe('build', function() {
        before(function() {
            $this->prophet = new Prophet();
            $this->service = $this->prophet->prophesize('coveralls\service\TravisCIInterface');
            $this->service->getJobId()->shouldBeCalled()->willReturn('10');
            $this->service->getServiceName()->shouldBeCalled()->willReturn('travis-ci');
            $this->foo = realpath(__DIR__ . '/jsonfile/fixtures/foo.php');
            $this->bar = realpath(__DIR__ . '/jsonfile/fixtures/bar.php');
            $this->builder = new JSONFileBuilder();
            $this->builder->token('foo');
            $this->builder->service($this->service->reveal());
            $this->builder->addSource(new SourceFile($this->foo));
            $this->builder->addSource(new SourceFile($this->bar));
            $this->jsonFile = $this->builder->build();
        });
        after(function() {
            $this->prophet->checkPredictions();
        });
        it('should set the service environment', function() {
            expect($this->jsonFile->service->getJobId())->toBe('10');
            expect($this->jsonFile->service->getServiceName())->toBe('travis-ci');
        });
        it('should set the repository token', function() {
            expect($this->jsonFile->token)->toBe('foo');
        });
        it('should add the source file', function() {
            expect($this->jsonFile->sourceFiles->has($this->foo))->toBeTrue();
            expect($this->jsonFile->sourceFiles->has($this->bar))->toBeTrue();
        });
    });
});
