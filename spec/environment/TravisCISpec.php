<?php

namespace coveralls\spec;

use coveralls\environment\TravisCI;

describe('TravisCI', function() {
    before(function() {
        $this->jobId = getenv('TRAVIS_JOB_ID');
        putenv('TRAVIS_JOB_ID=10');
        $this->env = new TravisCI();
    });
    after(function() {
        putenv('TRAVIS_JOB_ID=' . $this->jobId);
    });
    describe('jobId', function() {
        it('should return job id', function() {
            expect($this->env->jobId)->toEqual('10');
        });
    });
    describe('serviceName', function() {
        it('should return the service name', function() {
            expect($this->env->serviceName)->toEqual('travis-ci');
        });
    });
});
