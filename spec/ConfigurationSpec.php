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

use coverallskit\Configuration;
use Prophecy\Prophet;

describe('Configuration', function() {
    before(function() {
        $this->prophet = new Prophet();

        $this->service = $this->prophet->prophesize('coverallskit\entity\service\ServiceInterface');
        $this->service->getServiceJobId()->shouldNotBeCalled();
        $this->service->getServiceName()->shouldNotBeCalled();

        $this->configration = new Configuration([
            'name' => 'coveralls.json',
            'token' => 'api-token',
            'service' => $this->service->reveal(),
            'repositoryDirectory' => __DIR__
        ]);
    });
    after(function() {
        $this->prophet->checkPredictions();
    });
    describe('getName', function() {
        it('should return report file name', function() {
            expect($this->configration->getName())->toEqual('coveralls.json');
        });
    });
    describe('getToken', function() {
        it('should return coveralls api token', function() {
            expect($this->configration->getToken())->toEqual('api-token');
        });
    });
    describe('getService', function() {
        it('should return service instance', function() {
            expect($this->configration->getService())->toBeAnInstanceOf('\coverallskit\entity\service\ServiceInterface');
        });
    });
    describe('getRepositoryDirectory', function() {
        it('should return repository directory', function() {
            expect($this->configration->getRepositoryDirectory())->toEqual(__DIR__);
        });
    });
});
