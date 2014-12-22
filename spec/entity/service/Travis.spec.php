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

use coverallskit\Environment;
use Mockery;

describe('Travis', function() {

    beforeEach(function() {
        $className  = 'coverallskit\entity\service\Travis';
        $environment = new Environment([
            'TRAVIS_JOB_ID' => '10',
            'COVERALLS_REPO_TOKEN' => 'token'
        ]);
        $this->service = Mockery::mock($className, [$environment])->makePartial();
        $this->service->shouldReceive('getServiceName')->andReturn('travis-ci');
    });
    afterEach(function() {
        Mockery::close();
    });
    describe('getServiceJobId', function() {
        it('should return the service job id', function() {
            expect($this->service->getServiceJobId())->toEqual('10');
        });
    });
    describe('getServiceName', function() {
        it('should return the service name', function() {
            expect($this->service->getServiceName())->toEqual('travis-ci');
        });
    });
    describe('getCoverallsToken', function() {
        it('should return the coveralls api token', function() {
            expect($this->service->getCoverallsToken())->toEqual('token');
        });
    });
    describe('isEmpty', function() {
        it('should return false', function () {
            expect($this->service->isEmpty())->toBeFalse();
        });
    });
    describe('toArray', function() {
        beforeEach(function() {
            $this->values = $this->service->toArray();
        });
        it('should return array value', function () {
            expect($this->values)->toBeAn('array');
        });
        it('should array have service_job_id', function () {
            expect($this->values)->toHaveKey('service_job_id');
        });
        it('should array have service_name', function () {
            expect($this->values)->toHaveKey('service_name');
        });
    });
});
