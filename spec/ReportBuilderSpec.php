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

use coverallskit\ReportBuilder;
use coverallskit\entity\SourceFile;
use coverallskit\entity\repository\Commit;
use coverallskit\entity\repository\Branch;
use coverallskit\entity\repository\Remote;
use coverallskit\entity\collection\RemoteCollection;
use Prophecy\Prophet;
use Mockery;

describe('ReportBuilder', function() {

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
            $remote = new Remote([
                'name' => 'origin',
                'url' => 'https://github.com/holyshared/coverallskit-kit.git'
            ]);
            $this->remotes = new RemoteCollection([ $remote ]);

            $this->repository = $this->prophet->prophesize('coverallskit\entity\RepositoryInterface');
            $this->repository->getCommit()->willReturn($this->commit);
            $this->repository->getBranch()->willReturn($this->branch);
            $this->repository->getRemotes()->willReturn($this->remotes);

            $this->foo = realpath(__DIR__ . '/fixtures/foo.php');
            $this->bar = realpath(__DIR__ . '/fixtures/bar.php');

            $this->builder = new ReportBuilder();
            $this->builder->reportFilePath(__DIR__  . '/tmp/coverage.json');
            $this->builder->token('foo');
            $this->builder->repository($this->repository->reveal());
            $this->builder->service($this->service->reveal());
            $this->builder->addSource(new SourceFile($this->foo));
            $this->builder->addSource(new SourceFile($this->bar));

            $this->report = $this->builder->build();
        });
        after(function() {
            $this->prophet->checkPredictions();
        });
        it('should same as that specifies the name of the result report', function() {
            expect($this->report->name)->toBe(__DIR__  . '/tmp/coverage.json');
        });
        it('should same as that specifies the token of the result report', function() {
            expect($this->report->token)->toBe('foo');
        });
        it('should same as that specifies the service of the result report', function() {
            expect($this->report->service->getServiceJobId())->toBe('10');
            expect($this->report->service->getServiceName())->toBe('travis-ci');
        });
        it('should same as that specifies the repository of the result report', function() {
            expect($this->report->repository->getCommit())->toBe($this->commit);
            expect($this->report->repository->getBranch())->toBe($this->branch);
            expect($this->report->repository->getRemotes())->toBe($this->remotes);
        });
        it('should same as that specifies the sources of the result report', function() {
            expect($this->report->sourceFiles->has($this->foo))->toBeTrue();
            expect($this->report->sourceFiles->has($this->bar))->toBeTrue();
        });

        context('when not specify the required values' , function() {
            before(function() {
                $this->service = Mockery::mock('coverallskit\entity\service\TravisInterface');
                $this->service->shouldReceive('getServiceJobId');
                $this->service->shouldReceive('getServiceName');

                $this->repository = Mockery::mock('coverallskit\entity\RepositoryInterface');
                $this->repository->shouldReceive('getCommit');
                $this->repository->shouldReceive('getBranch');
            });
            after(function() {
                Mockery::close();
            });
            context('when not specify reportFilePath' , function() {
                before(function() {
                    $this->builder = new ReportBuilder();
                    $this->builder->repository($this->repository);
                    $this->builder->service($this->service);
                });
                it('should throw coverallskit\exception\RequiredException', function() {
                    expect(function() {
                        $this->builder->build();
                    })->toThrow('coverallskit\exception\RequiredException');
                });
            });
            context('when not specify service' , function() {
                before(function() {
                    $this->builder = new ReportBuilder();
                    $this->builder->reportFilePath(__DIR__  . '/tmp/coverage.json');
                    $this->builder->repository($this->repository);
                });
                it('should throw coverallskit\exception\RequiredException', function() {
                    expect(function() {
                        $this->builder->build();
                    })->toThrow('coverallskit\exception\RequiredException');
                });
            });
            context('when not specify repository' , function() {
                before(function() {
                    $this->builder = new ReportBuilder();
                    $this->builder->reportFilePath(__DIR__  . '/tmp/coverage.json');
                    $this->builder->service($this->service);
                });
                it('should throw coverallskit\exception\RequiredException', function() {
                    expect(function() {
                        $this->builder->build();
                    })->toThrow('coverallskit\exception\RequiredException');
                });
            });
        });

    });
});
