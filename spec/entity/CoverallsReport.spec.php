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

use coverallskit\entity\collection\SourceFileCollection;
use coverallskit\entity\CoverallsReport;
use coverallskit\entity\GitRepository;
use coverallskit\entity\RepositoryEntity;
use coverallskit\entity\ServiceEntity;
use coverallskit\entity\SourceFile;
use coverallskit\exception\RequiredException;
use coverallskit\ReportTransfer;
use Prophecy\Prophet;

describe(CoverallsReport::class, function () {
    beforeEach(function () {
        $this->path = __DIR__ . '/tmp/coverage.json';

        mkdir(__DIR__ . '/tmp');
    });
    afterEach(function () {
        rmdir(__DIR__ . '/tmp');
    });

    describe('isEmpty', function () {
        context('when empty', function () {
            it('should return true', function () {
                $report = new CoverallsReport();
                expect($report->isEmpty())->toBeTrue();
            });
        });
    });
    describe('token', function () {
        it('should return repository token string', function () {
            $report = new CoverallsReport([ 'token' => 'foo' ]);
            expect($report->getToken())->toBe('foo');
        });
    });
    describe('repository', function () {
        it('should return repository', function () {
            $report = new CoverallsReport([
                'repository' => new GitRepository(__DIR__ . '/../../')
            ]);
            expect($report->getRepository())->toBeAnInstanceOf(RepositoryEntity::class);
        });
    });
    describe('sourceFiles', function () {
        it('should return sources file collection', function () {
            $report = new CoverallsReport([
                'sourceFiles' => new SourceFileCollection()
            ]);
            expect($report->getSourceFiles())->toBeAnInstanceOf(SourceFileCollection::class);
        });
    });

    describe('#validate', function () {
        context('when token empty', function () {
            beforeEach(function () {
                $this->report = new CoverallsReport([ 'token' => null ]);
            });
            it('throw coverallskit\exception\RequiredException', function () {
                expect(function () {
                    $this->report->validate();
                })->toThrow(RequiredException::class);
            });
        });
        context('when service empty', function () {
            beforeEach(function () {
                $this->prophet = new Prophet();

                $service = $this->prophet->prophesize(ServiceEntity::class);
                $service->isEmpty()->willReturn(true);

                $this->report = new CoverallsReport([
                    'token' => 'foo',
                    'service' => $service->reveal()
                ]);
            });
            it('throw coverallskit\exception\RequiredException', function () {
                expect(function () {
                    $this->report->validate();
                })->toThrow(RequiredException::class);
            });
        });
        context('when source file empty', function () {
            beforeEach(function () {
                $this->prophet = new Prophet();

                $service = $this->prophet->prophesize(ServiceEntity::class);
                $service->isEmpty()->willReturn(false);

                $this->report = new CoverallsReport([
                    'token' => 'foo',
                    'service' => $service->reveal(),
                    'sourceFiles' => new SourceFileCollection()
                ]);
            });
            it('throw coverallskit\exception\RequiredException', function () {
                expect(function () {
                    $this->report->validate();
                })->toThrow(RequiredException::class);
            });
        });
    });

    describe('saveAs', function () {
        beforeEach(function () {
            $this->prophet = new Prophet();

            $sourceFiles = new SourceFileCollection([
                new SourceFile(realpath(__DIR__ . '/../fixtures/foo.php')),
                new SourceFile(realpath(__DIR__ . '/../fixtures/bar.php'))
            ]);

            $service = $this->prophet->prophesize(ServiceEntity::class);
            $service->isEmpty()->willReturn(false);
            $service->toArray()->willReturn([
                'service_job_id' => '10',
                'service_name' => 'travis-ci'
            ]);

            $this->report = new CoverallsReport([
                'token' => 'foo',
                'repository' => new GitRepository(__DIR__ . '/../../'),
                'service' => $service->reveal(),
                'sourceFiles' => $sourceFiles
            ]);

            $this->report->saveAs($this->path);
            $this->jsonResult = json_decode(file_get_contents($this->path));
        });
        afterEach(function () {
            unlink($this->path);
        });
        it('should saved the file', function () {
            expect(file_exists($this->path))->toBeTrue();
        });
        it('should have a key git', function () {
            expect($this->jsonResult->git->head->id)->toBeAn('string');
            expect($this->jsonResult->git->branch)->toBeAn('string');
            expect($this->jsonResult->git->remotes)->toHaveKey(0);
        });
    });
    describe('upload', function () {
        context('when not saved file', function () {
            beforeEach(function () {
                $this->prophet = new Prophet();

                $sourceFiles = new SourceFileCollection([
                    new SourceFile(realpath(__DIR__ . '/../fixtures/foo.php')),
                    new SourceFile(realpath(__DIR__ . '/../fixtures/bar.php'))
                ]);

                $service = $this->prophet->prophesize(ServiceEntity::class);
                $service->isEmpty()->willReturn(false);
                $service->toArray()->willReturn([
                    'service_job_id' => '10',
                    'service_name' => 'travis-ci'
                ]);

                $this->notSavedReport = new CoverallsReport([
                    'token' => 'foo',
                    'repository' => new GitRepository(__DIR__ . '/../../'),
                    'service' => $service->reveal(),
                    'sourceFiles' => $sourceFiles
                ]);

                $this->notSavedFileUpLoader = $this->prophet->prophesize(ReportTransfer::class);
                $this->notSavedFileUpLoader->upload($this->notSavedReport)->shouldBeCalled();

                $this->notSavedReport->setReportTransfer($this->notSavedFileUpLoader->reveal());
                $this->notSavedReport->upload();
            });
            afterEach(function () {
                unlink($this->notSavedReport->getName());
            });
            it('should use the default name', function () {
                expect($this->notSavedReport->getName())->toEqual(getcwd() . '/' . CoverallsReport::DEFAULT_NAME);
            });
            it('upload the report file', function () {
                $this->prophet->checkPredictions();
            });
        });
        context('when saved file', function () {
            beforeEach(function () {
                $this->prophet = new Prophet();

                $sourceFiles = new SourceFileCollection([
                    new SourceFile(realpath(__DIR__ . '/../fixtures/foo.php')),
                    new SourceFile(realpath(__DIR__ . '/../fixtures/bar.php'))
                ]);

                $service = $this->prophet->prophesize(ServiceEntity::class);
                $service->isEmpty()->willReturn(false);
                $service->toArray()->willReturn([
                    'service_job_id' => '10',
                    'service_name' => 'travis-ci'
                ]);

                $this->savedReport = new CoverallsReport([
                    'token' => 'foo',
                    'repository' => new GitRepository(__DIR__ . '/../../'),
                    'service' => $service->reveal(),
                    'sourceFiles' => $sourceFiles
                ]);
                $this->savedFileUpLoader = $this->prophet->prophesize(ReportTransfer::class);
                $this->savedFileUpLoader->upload($this->savedReport)->shouldBeCalled();

                $this->savedReport->setReportTransfer($this->savedFileUpLoader->reveal());

                $this->savedReport->saveAs($this->path);
                $this->savedReport->upload();
            });
            afterEach(function () {
                unlink($this->savedReport->getName());
            });
            it('use a file name that you specify', function () {
                expect($this->savedReport->getName())->toEqual($this->path);
            });
            it('upload the report file', function () {
                $this->prophet->checkPredictions();
            });
        });
    });
});
