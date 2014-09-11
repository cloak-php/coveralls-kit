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

use coverallskit\entity\Report;
use coverallskit\entity\Repository;
use coverallskit\entity\collection\SourceFileCollection;
use Prophecy\Prophet;


describe('Report', function() {
    before(function() {
        mkdir(__DIR__ . '/tmp');

        $this->prophet = new Prophet();

        $this->service = $this->prophet->prophesize('coverallskit\entity\service\TravisInterface');
        $this->service->toArray()->shouldBeCalled()->willReturn([
            'service_job_id' => '10',
            'service_name' => 'travis-ci'
        ]);

        $this->path = __DIR__ . '/tmp/coverage.json';

        $this->report = new Report([
            'token' => 'foo',
            'repository' => new Repository(__DIR__ . '/../../'),
            'service' => $this->service->reveal(),
            'sourceFiles' => new SourceFileCollection()
        ]);
    });

    after(function() {
        rmdir(__DIR__ . '/tmp');

        $this->prophet->checkPredictions();
    });

    describe('isEmpty', function() {
        context('when empty', function() {
            it('should return true', function () {
                $report = new Report();
                expect($report->isEmpty())->toBeTrue();
            });
        });
    });

    describe('token', function() {
        it('should return repository token string', function() {
            expect($this->report->token)->toBe('foo');
        });
    });
    describe('repository', function() {
        it('should return repository', function() {
            expect($this->report->repository)->toBeAnInstanceOf('coverallskit\entity\Repository');
        });
    });
    describe('sourceFiles', function() {
        it('should return sources file collection', function() {
            expect($this->report->sourceFiles)->toBeAnInstanceOf('coverallskit\entity\collection\SourceFileCollection');
        });
    });
    describe('saveAs', function() {
        before(function() {
            $this->report->saveAs($this->path);
            $this->jsonResult = json_decode(file_get_contents($this->path));
        });
        after(function() {
            unlink($this->path);
        });
        it('should saved the file', function() {
            expect(file_exists($this->path))->toBeTrue();
        });
        it('should have a key git', function() {
            expect($this->jsonResult->git->head->id)->toBeAn('string');
            expect($this->jsonResult->git->branch)->toBeAn('string');
            expect($this->jsonResult->git->remotes)->toHaveKey(0);
        });
    });
    describe('upload', function() {
        context('when not saved file', function() {
            before(function() {
                $this->prophet = new Prophet();

                $this->notSavedReport = new Report([
                    'token' => 'foo',
                    'repository' => new Repository(__DIR__ . '/../../'),
                    'service' => $this->service->reveal(),
                    'sourceFiles' => new SourceFileCollection()
                ]);

                $this->notSavedFileUpLoader = $this->prophet->prophesize('coverallskit\ReportTransferInterface');
                $this->notSavedFileUpLoader->upload($this->notSavedReport)->shouldBeCalled();

                $this->notSavedReport->setReportTransfer($this->notSavedFileUpLoader->reveal());
                $this->notSavedReport->upload();
            });
            after(function() {
                unlink($this->notSavedReport->getName());
            });
            it('should use the default name', function() {
                expect($this->notSavedReport->getName())->toEqual(getcwd() . '/' . Report::DEFAULT_NAME);
            });
            it('upload the report file', function() {
                $this->prophet->checkPredictions();
            });
        });
        context('when saved file', function() {
            before(function() {
                $this->prophet = new Prophet();

                $this->savedReport = new Report([
                    'token' => 'foo',
                    'repository' => new Repository(__DIR__ . '/../../'),
                    'service' => $this->service->reveal(),
                    'sourceFiles' => new SourceFileCollection()
                ]);
                $this->savedFileUpLoader = $this->prophet->prophesize('coverallskit\ReportTransferInterface');
                $this->savedFileUpLoader->upload($this->savedReport)->shouldBeCalled();

                $this->savedReport->setReportTransfer($this->savedFileUpLoader->reveal());

                $this->savedReport->saveAs($this->path);
                $this->savedReport->upload();
            });
            after(function() {
                unlink($this->savedReport->getName());
            });
            it('use a file name that you specify', function() {
                expect($this->savedReport->getName())->toEqual($this->path);
            });
            it('upload the report file', function() {
                $this->prophet->checkPredictions();
            });
        });
    });
});
