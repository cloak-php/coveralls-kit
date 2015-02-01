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
use coverallskit\entity\Service;
use Prophecy\Prophet;


describe('Service', function() {
    beforeEach(function() {
        $this->prophet = new Prophet();

        $adaptor = $this->prophet->prophesize('coverallskit\environment\AdaptorInterface');
        $adaptor->getName()->willReturn('travis-ci');
        $adaptor->getBuildJobId()->willReturn('10');
        $adaptor->getCoverallsToken()->willReturn('token');
        $adaptor->isSupported()->willReturn(true);

        $this->service = new Service($adaptor->reveal());
    });
    describe('getServiceName', function() {
        it('return service name', function() {
            expect($this->service->getServiceName())->toBe('travis-ci');
        });
    });
    describe('getServiceJobId', function() {
        it('return build job id', function() {
            expect($this->service->getServiceJobId())->toBe('10');
        });
    });
    describe('getCoverallsToken', function() {
        it('return coveralls api token value', function() {
            expect($this->service->getCoverallsToken())->toBe('token');
        });
    });
    describe('isEmpty', function() {
        context('when empty', function() {
            it('return false', function() {
                expect($this->service->isEmpty())->toBeFalse();
            });
        });
    });
    describe('__toString', function() {
        it('return json string', function() {
            $expectValue = '{"service_name":"travis-ci","service_job_id":"10"}';
            $actualValue = (string) $this->service;
            expect($actualValue)->toBe($expectValue);
        });
    });
});
