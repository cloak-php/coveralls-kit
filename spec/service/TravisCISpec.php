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

use coveralls\service\TravisCI;

describe('TravisCI', function() {
    before(function() {
        $this->jobId = getenv('TRAVIS_JOB_ID');
        putenv('TRAVIS_JOB_ID=10');
        $this->service = new TravisCI();
    });
    after(function() {
        putenv('TRAVIS_JOB_ID=' . $this->jobId);
    });
    describe('jobId', function() {
        it('should return job id', function() {
            expect($this->service->getJobId())->toEqual('10');
        });
    });
    describe('serviceName', function() {
        it('should return the service name', function() {
            expect($this->service->getServiceName())->toEqual('travis-ci');
        });
    });
    describe('ci', function() {
        it('should return travis-ci service', function() {
            expect(TravisCI::ci()->getServiceName())->toEqual('travis-ci');
        });
    });
    describe('pro', function() {
        it('should return travis-pro service', function() {
            expect(TravisCI::pro()->getServiceName())->toEqual('travis-pro');
        });
    });
});
