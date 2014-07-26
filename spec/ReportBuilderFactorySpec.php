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

use coverallskit\ReportBuilderFactory;
use Prophecy\Prophet;
use Prophecy\Argument;

describe('ReportBuilderFactory', function() {
    describe('createFromConfigurationFile', function() {
        before(function() {
            $this->prophet = new Prophet();

            $service = $this->prophet->prophesize('coverallskit\entity\service\ServiceInterface');
            $service->getServiceJobId()->shouldNotBeCalled();
            $service->getServiceName()->shouldNotBeCalled();

            $repository = $this->prophet->prophesize('coverallskit\entity\RepositoryInterface');
            $repository->getCommit()->shouldNotBeCalled();
            $repository->getBranch()->shouldNotBeCalled();
            $repository->getRemotes()->shouldNotBeCalled();

            $configration = $this->prophet->prophesize('coverallskit\ConfigurationInterface');

            $configration->getReportFileName()->shouldNotBeCalled();
            $configration->getToken()->shouldNotBeCalled();
            $configration->getService()->shouldNotBeCalled();
            $configration->getRepository()->shouldNotBeCalled();
            $configration->applyTo(Argument::type('coverallskit\ReportBuilderInterface'))->willReturnArgument();

            $loader = $this->prophet->prophesize('coverallskit\ConfigurationLoaderInterface');
            $loader->loadFromFile(__DIR__ . '/fixtures/coveralls.yml')->willReturn($configration->reveal());

            $this->factory = new ReportBuilderFactory($loader->reveal());
            $this->builder = $this->factory->createFromConfigurationFile(__DIR__ . '/fixtures/coveralls.yml');
        });
        it('should return coverallskit\ReportBuilderInterface instance', function() {
            expect($this->builder)->toBeAnInstanceOf('\coverallskit\ReportBuilderInterface');
        });
    });
});
