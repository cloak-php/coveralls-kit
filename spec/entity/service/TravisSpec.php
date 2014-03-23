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

use coveralls\entity\service\Travis;

describe('Travis', function() {
    before(function() {
        $this->jobId = getenv('TRAVIS_JOB_ID');
        putenv('TRAVIS_JOB_ID=10');
        $this->service = new Travis();
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
    describe('travisCI', function() {
        it('should return travis-ci service', function() {
            expect(Travis::travisCI()->getServiceName())->toEqual('travis-ci');
        });
    });
    describe('travisPro', function() {
        it('should return travis-pro service', function() {
            expect(Travis::travisPro()->getServiceName())->toEqual('travis-pro');
        });
    });
});
