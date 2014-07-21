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

    describe('__construct', function() {
        context('when specify the attribute', function() {
            before(function() {
                $this->prophet = new Prophet();

                $this->service = $this->prophet->prophesize('coverallskit\entity\service\ServiceInterface');
                $this->service->getServiceJobId()->shouldNotBeCalled();
                $this->service->getServiceName()->shouldNotBeCalled();

                $this->repository = $this->prophet->prophesize('coverallskit\entity\RepositoryInterface');
                $this->repository->getCommit()->shouldNotBeCalled();
                $this->repository->getBranch()->shouldNotBeCalled();
                $this->repository->getRemotes()->shouldNotBeCalled();

                $this->configration = new Configuration([
                    'name' => 'coveralls.json',
                    'token' => 'api-token',
                    'service' => $this->service->reveal(),
                    'repository' => $this->repository->reveal()
                ]);
            });
            after(function() {
                $this->prophet->checkPredictions();
            });
            it('should set the name', function() {
                expect($this->configration->getName())->toEqual('coveralls.json');
            });
            it('should set the coveralls api token', function() {
                expect($this->configration->getToken())->toEqual('api-token');
            });
            it('should set the service instance', function() {
                expect($this->configration->getService())->toBeAnInstanceOf('\coverallskit\entity\service\ServiceInterface');
            });
            it('should set the repository', function() {
                expect($this->configration->getRepository())->toBeAnInstanceOf('\coverallskit\entity\RepositoryInterface');
            });
        });
        context('when specify an attribute that does not exist', function() {
            it('should throw coverallskit\exception\BadAttributeException', function() {
                expect(function() {
                    new Configuration([ 'does not exist' => 'foo' ]);
                })->toThrow('coverallskit\exception\BadAttributeException');
            });
        });
    });

    describe('applyTo', function() {
        before(function() {
            $this->prophet = new Prophet();

            $service = $this->prophet->prophesize('coverallskit\entity\service\ServiceInterface');
            $service->getServiceJobId()->shouldNotBeCalled();
            $service->getServiceName()->shouldNotBeCalled();

            $this->service = $service->reveal();

            $repository = $this->prophet->prophesize('coverallskit\entity\RepositoryInterface');
            $repository->getCommit()->shouldNotBeCalled();
            $repository->getBranch()->shouldNotBeCalled();
            $repository->getRemotes()->shouldNotBeCalled();

            $this->repository = $repository->reveal();

            $this->configration = new Configuration([
                'name' => 'coveralls.json',
                'token' => 'api-token',
                'service' => $this->service,
                'repository' => $this->repository
            ]);

            $builder = $this->prophet->prophesize('\coverallskit\ReportBuilderInterface');
            $builder->name('coveralls.json')->willReturn($builder);
            $builder->token('api-token')->willReturn($builder);
            $builder->service($this->service)->willReturn($builder);
            $builder->repository($this->repository)->willReturn($builder);
            $builder->build()->shouldNotBeCalled();

            $this->builder = $builder->reveal();
        });
        after(function() {
            $this->prophet->checkPredictions();
        });
        it('should apply configration', function() {
            $this->configration->applyTo($this->builder);
        });
    });

    describe('createReportBuilder', function() {
        before(function() {
            $this->prophet = new Prophet();

            $service = $this->prophet->prophesize('coverallskit\entity\service\ServiceInterface');
            $service->getServiceJobId()->shouldNotBeCalled();
            $service->getServiceName()->shouldNotBeCalled();

            $this->service = $service->reveal();

            $repository = $this->prophet->prophesize('coverallskit\entity\RepositoryInterface');
            $repository->getCommit()->shouldNotBeCalled();
            $repository->getBranch()->shouldNotBeCalled();
            $repository->getRemotes()->shouldNotBeCalled();

            $this->repository = $repository->reveal();

            $this->configration = new Configuration([
                'name' => 'coveralls.json',
                'token' => 'api-token',
                'service' => $this->service,
                'repository' => $this->repository
            ]);
        });
        after(function() {
            $this->prophet->checkPredictions();
        });
        it('should return \coverallskit\ReportBuilderInterface instance', function() {
            expect($this->configration->createReportBuilder())->toBeAnInstanceOf('\coverallskit\ReportBuilderInterface');
        });
    });

});
