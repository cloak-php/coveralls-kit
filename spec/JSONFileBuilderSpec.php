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

use coverallskit\JSONFileBuilder;
use coverallskit\entity\SourceFile;
use coverallskit\entity\repository\Commit;
use coverallskit\entity\repository\Branch;
use coverallskit\entity\repository\Remote;
use coverallskit\entity\collection\RemoteCollection;
use Prophecy\Prophet;

describe('JSONFileBuilder', function() {
    describe('build', function() {
        before(function() {
            $this->prophet = new Prophet();

            $this->service = $this->prophet->prophesize('coverallskit\entity\service\TravisInterface');
            $this->service->getServiceJobId()->shouldBeCalled()->willReturn('10');
            $this->service->getServiceName()->shouldBeCalled()->willReturn('travis-ci');

            $this->commit = new Commit([
                'id' => '3fdcfa494f3e9bcb17f90085af9d11a936a7ef4e',
                'authorName' => 'holyshared',
                'authorEmail' => 'holy.shared.design@gmail.com',
                'committerName' => 'holyshared',
                'committerEmail' => 'holy.shared.design@gmail.com',
                'message' => 'first commit'
            ]);
            $this->branch = new Branch([
                'name' => 'master',
                'remote' => false
            ]);
            $remote = new Remote('origin', 'https://github.com/holyshared/coverallskit-kit.git');
            $this->remotes = new RemoteCollection([ $remote ]);

            $this->repository = $this->prophet->prophesize('coverallskit\entity\RepositoryInterface');
            $this->repository->getCommit()->willReturn($this->commit);
            $this->repository->getBranch()->willReturn($this->branch);
            $this->repository->getRemotes()->willReturn($this->remotes);

            $this->foo = realpath(__DIR__ . '/fixtures/foo.php');
            $this->bar = realpath(__DIR__ . '/fixtures/bar.php');

            $this->builder = new JSONFileBuilder();
            $this->builder->token('foo');
            $this->builder->repository($this->repository->reveal());
            $this->builder->service($this->service->reveal());
            $this->builder->addSource(new SourceFile($this->foo));
            $this->builder->addSource(new SourceFile($this->bar));

            $this->jsonFile = $this->builder->build();
        });
        after(function() {
            $this->prophet->checkPredictions();
        });
        it('should set the repository token', function() {
            expect($this->jsonFile->token)->toBe('foo');
        });
        it('should set the service environment', function() {
            expect($this->jsonFile->service->getServiceJobId())->toBe('10');
            expect($this->jsonFile->service->getServiceName())->toBe('travis-ci');
        });
        it('should set the commit log', function() {
            expect($this->jsonFile->repository->getCommit())->toBe($this->commit);
            expect($this->jsonFile->repository->getBranch())->toBe($this->branch);
            expect($this->jsonFile->repository->getRemotes())->toBe($this->remotes);
        });
        it('should add the source file', function() {
            expect($this->jsonFile->sourceFiles->has($this->foo))->toBeTrue();
            expect($this->jsonFile->sourceFiles->has($this->bar))->toBeTrue();
        });
    });
});
