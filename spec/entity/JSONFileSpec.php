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

use coveralls\entity\JSONFile;
use coveralls\entity\Repository;
use coveralls\entity\collection\SourceFileCollection;
use coveralls\entity\service\TravisInterface;
use Prophecy\Prophet;

describe('JSONFile', function() {
    before(function() {
        $this->prophet = new Prophet();

        $this->service = $this->prophet->prophesize('coveralls\entity\service\TravisInterface');
        $this->service->toArray()->shouldBeCalled()->willReturn([
            'service_job_id' => '10',
            'service_name' => 'travis-ci'
        ]);

        $this->jsonFile = new JSONFile([
            'token' => 'foo',
            'repository' => new Repository(__DIR__ . '/../../'),
            'service' => $this->service->reveal(),
            'sourceFiles' => new SourceFileCollection()
        ]);

        $this->fileUpLoader = $this->prophet->prophesize('coveralls\JSONFileUpLoaderInterface');
        $this->fileUpLoader->upload($this->jsonFile)->shouldBeCalled();

        $this->jsonFile->setUpLoader($this->fileUpLoader->reveal());
    });
    after(function() {
        $this->prophet->checkPredictions();
    });
    describe('token', function() {
        it('should return repository token string', function() {
            expect($this->jsonFile->token)->toBe('foo');
        });
    });
    describe('repository', function() {
        it('should return repository', function() {
            expect($this->jsonFile->repository)->toBeAnInstanceOf('coveralls\entity\Repository');
        });
    });
    describe('sourceFiles', function() {
        it('should return sources file collection', function() {
            expect($this->jsonFile->sourceFiles)->toBeAnInstanceOf('coveralls\entity\collection\SourceFileCollection');
        });
    });
    describe('saveAs', function() {
        before(function() {
            mkdir(__DIR__ . '/tmp');
            $this->path = __DIR__ . '/tmp/coverage.json';
            $this->jsonFile->saveAs($this->path);
            $this->jsonResult = json_decode(file_get_contents($this->path));
        });
        after(function() {
            unlink($this->path);
            rmdir(__DIR__ . '/tmp');
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
        it('should upload the json file', function() {
            $this->jsonFile->upload();
        });
    });

});
