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

use coverallskit\entity\CIService;
use coverallskit\Environment;
use coverallskit\environment\EnvironmentAdapter;
use Prophecy\Prophet;

describe(CIService::class, function () {
    beforeEach(function () {
        $this->prophet = new Prophet();

        $adapter = $this->prophet->prophesize(EnvironmentAdapter::class);
        $adapter->getName()->willReturn('travis-ci');
        $adapter->getBuildJobId()->willReturn('10');
        $adapter->getCoverallsToken()->willReturn('token');
        $adapter->isSupported()->willReturn(true);

        $this->service = new CIService($adapter->reveal());
    });
    describe('getServiceName', function () {
        it('return service name', function () {
            expect($this->service->getServiceName())->toBe('travis-ci');
        });
    });
    describe('getServiceJobId', function () {
        it('return build job id', function () {
            expect($this->service->getServiceJobId())->toBe('10');
        });
    });
    describe('getCoverallsToken', function () {
        it('return coveralls api token value', function () {
            expect($this->service->getCoverallsToken())->toBe('token');
        });
    });
    describe('isEmpty', function () {
        context('when empty', function () {
            it('return false', function () {
                expect($this->service->isEmpty())->toBeFalse();
            });
        });
    });
    describe('__toString', function () {
        it('return json string', function () {
            $expectValue = '{"service_name":"travis-ci","service_job_id":"10"}';
            $actualValue = (string) $this->service;
            expect($actualValue)->toBe($expectValue);
        });
    });
});
