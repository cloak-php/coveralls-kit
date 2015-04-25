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
use coverallskit\configuration\Basic;
use coverallskit\ReportBuilder;
use Zend\Config\Config;
use Eloquent\Pathogen\Factory\PathFactory;


describe('Basic', function() {

    beforeEach(function() {
        $this->configDirectory = __DIR__ . '/../fixtures/';

        $factory = PathFactory::instance();
        $rootPath = $factory->create($this->configDirectory);

        $config = new Config([
            Basic::TOKEN_KEY => 'api-token',
            Basic::SERVICE_KEY => 'travis-ci',
            Basic::REPOSITORY_DIRECTORY_KEY => __DIR__ . '/../../'
        ]);

        $this->configration = new Basic($config, $rootPath);
    });

    describe('__construct', function() {
        it('set the coveralls api token', function() {
            expect($this->configration->getToken())->toEqual('api-token');
        });
        it('set the service instance', function() {
            expect($this->configration->getService())->toBeAnInstanceOf('\coverallskit\entity\ServiceInterface');
        });
        it('set the repository', function() {
            expect($this->configration->getRepository())->toBeAnInstanceOf('\coverallskit\entity\RepositoryEntity');
        });
    });
    describe('applyTo', function() {
        beforeEach(function() {
            $this->builder = new ReportBuilder();
            $this->configration->applyTo($this->builder);
        });
        it('apply token config', function() {
            expect($this->builder->getToken())->toEqual('api-token');
        });
        it('apply service config', function() {
            expect($this->builder->getService())->toBeAnInstanceOf('coverallskit\entity\ServiceInterface');
        });
        it('apply repository config', function() {
            expect($this->builder->getRepository())->toBeAnInstanceOf('coverallskit\entity\RepositoryEntity');
        });
    });
});
