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
use coverallskit\environment\AdapterResolver;
use coverallskit\environment\CircleCI;
use coverallskit\environment\CodeShip;
use coverallskit\environment\DroneIO;
use coverallskit\environment\General;
use coverallskit\environment\Jenkins;
use coverallskit\environment\TravisCI;
use coverallskit\exception\EnvironmentAdapterNotFoundException;

describe(AdapterResolver::class, function () {
    describe('#resolveByEnvironment', function () {
        context('when supported', function () {
            context('when circle-ci', function () {
                beforeEach(function () {
                    $environment = new Environment([
                        'CI' => 'true',
                        'CIRCLECI' => 'true',
                        'CIRCLE_BUILD_NUM' => '10',
                        'COVERALLS_REPO_TOKEN' => 'token'
                    ]);
                    $this->resolver = new AdapterResolver($environment);
                });
                it('return detect circle-ci adapter', function () {
                    $adapter = $this->resolver->resolveByEnvironment();
                    expect($adapter)->toBeAnInstanceOf(CircleCI::class);
                });
            });
            context('when drone.io', function () {
                beforeEach(function () {
                    $environment = new Environment([
                        'CI' => 'true',
                        'DRONE' => 'true',
                        'DRONE_BUILD_NUMBER' => '10',
                        'COVERALLS_REPO_TOKEN' => 'token'
                    ]);
                    $this->resolver = new AdapterResolver($environment);
                });
                it('return detect drone.io adapter', function () {
                    $adapter = $this->resolver->resolveByEnvironment();
                    expect($adapter)->toBeAnInstanceOf(DroneIO::class);
                });
            });
            context('when travis-ci', function () {
                beforeEach(function () {
                    $environment = new Environment([
                        'CI' => 'true',
                        'TRAVIS' => 'true',
                        'TRAVIS_JOB_ID' => '10',
                        'COVERALLS_REPO_TOKEN' => 'token'
                    ]);
                    $this->resolver = new AdapterResolver($environment);
                });
                it('return detect travis-ci adapter', function () {
                    $adapter = $this->resolver->resolveByEnvironment();
                    expect($adapter)->toBeAnInstanceOf(TravisCI::class);
                });
            });
            context('when codeship', function () {
                beforeEach(function () {
                    $environment = new Environment([
                        'CI' => 'true',
                        'CI_NAME' => 'codeship',
                        'CI_BUILD_NUMBER' => '10',
                        'COVERALLS_REPO_TOKEN' => 'token'
                    ]);
                    $this->resolver = new AdapterResolver($environment);
                });
                it('return detect codeship adapter', function () {
                    $adapter = $this->resolver->resolveByEnvironment();
                    expect($adapter)->toBeAnInstanceOf(CodeShip::class);
                });
            });
            context('when jenkins', function () {
                beforeEach(function () {
                    $environment = new Environment([
                        'BUILD_NUMBER' => '10',
                        'JENKINS_URL' => 'http://example.com'
                    ]);
                    $this->resolver = new AdapterResolver($environment);
                });
                it('return detect jenkins adapter', function () {
                    $adapter = $this->resolver->resolveByEnvironment();
                    expect($adapter)->toBeAnInstanceOf(Jenkins::class);
                });
            });
        });
        context('when not supported', function () {
            beforeEach(function () {
                $environment = new Environment([]);
                $this->resolver = new AdapterResolver($environment);
            });
            it('return general adapter', function () {
                $adapter = $this->resolver->resolveByEnvironment();
                expect($adapter)->toBeAnInstanceOf(General::class);
            });
        });
    });
    describe('#resolveByName', function () {
        beforeEach(function () {
            $environment = new Environment([]);
            $this->detector = new AdapterResolver($environment);
        });
        context('when supported', function () {
            it('return detect adapter', function () {
                $adapter = $this->resolver->resolveByName('circle-ci');
                expect($adapter)->toBeAnInstanceOf(CircleCI::class);
            });
        });
        context('when not supported', function () {
            it('throw \coverallskit\exception\EnvironmentAdapterNotFoundException exception', function () {
                expect(function () {
                    $this->resolver->resolveByName('not_found');
                })->toThrow(EnvironmentAdapterNotFoundException::class);
            });
        });
    });
});
