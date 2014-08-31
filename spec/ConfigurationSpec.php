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
use Prophecy\Argument;
use Zend\Config\Config;

describe('Configuration', function() {

    describe('__construct', function() {
        context('when specify the attribute', function() {
            before(function() {
                $config = new Config([
                    'reportFile' => [
                        'output' => 'coveralls.json'
                    ],
                    'token' => 'api-token',
                    'service' => 'travis-ci',
                    'repository' => __DIR__ . '/../'
                ]);

                $this->configration = new Configuration($config);
            });
            it('should set the name', function() {
                expect($this->configration->getReportFileName())->toEqual(getcwd() . '/coveralls.json');
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
    });

    describe('applyTo', function() {
        before(function() {
            $this->prophet = new Prophet();

            $config = new Config([
                'reportFile' => [
                    'output' => 'coveralls.json'
                ],
                'token' => 'api-token',
                'service' => 'travis-ci',
                'repository' => __DIR__ . '/../'
            ]);

            $this->configration = new Configuration($config);

            $builder = $this->prophet->prophesize('\coverallskit\ReportBuilderInterface');
            $builder->reportFilePath(getcwd() . '/coveralls.json')->willReturn($builder);
            $builder->token('api-token')->willReturn($builder);
            $builder->service(Argument::type('coverallskit\entity\service\ServiceInterface'))->willReturn($builder);
            $builder->repository(Argument::type('coverallskit\entity\RepositoryInterface'))->willReturn($builder);

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

});
