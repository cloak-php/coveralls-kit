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

use coverallskit\entity\service\Travis;

describe('Travis', function() {
    before(function() {
        $this->jobId = getenv(Travis::ENV_JOB_ID);
//        $this->coverallsToken = getenv(Travis::ENV_COVERALLS_REPO_TOKEN_KEY);
        putenv(Travis::ENV_JOB_ID . '=10');
  //      putenv(Travis::ENV_COVERALLS_REPO_TOKEN_KEY . '=token');
        $this->service = new Travis();
    });
    after(function() {
        putenv(Travis::ENV_JOB_ID . '=' . $this->jobId);
    //    putenv(Travis::ENV_COVERALLS_REPO_TOKEN_KEY . '=' . $this->coverallsToken);
    });

    describe('isEmpty', function() {
        context('when service name is empty', function() {
            it('should return true', function () {
                $travis = new Travis(null);
                expect($travis->isEmpty())->toBeTrue();
            });
        });
    });

    describe('getServiceJobId', function() {
        it('should return job id', function() {
            expect($this->service->getServiceJobId())->toEqual('10');
        });
    });
    describe('getServiceName', function() {
        it('should return the service name', function() {
            expect($this->service->getServiceName())->toEqual('travis-ci');
        });
    });
//    describe('getCoverallsToken', function() {
  //      it('should return the coveralls api token', function() {
    //        expect($this->service->getCoverallsToken())->toEqual('token');
      //  });
//    });
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
