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
use coverallskit\CoverallsReportBuilder;
use Prophecy\Argument;
use Zend\Config\Config;

describe('Configuration', function() {

    describe('__construct', function() {
        context('when specify the attribute', function() {
            beforeEach(function() {
                $config = new Config([
                    'reportFile' => [
                        'input' => [
                            'type' => 'clover',
                            'file' => 'clover.xml'
                        ],
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
            it('return code coverage report file type', function() {
                expect($this->configration->getCoverageReportFileType())->toEqual('clover');
            });
            it('return code coverage report file name', function() {
                $filePath = realpath(__DIR__ . '/../') . '/clover.xml';
                expect($this->configration->getCoverageReportFilePath())->toEqual($filePath);
            });
            it('should set the coveralls api token', function() {
                expect($this->configration->getToken())->toEqual('api-token');
            });
            it('should set the service instance', function() {
                expect($this->configration->getService())->toBeAnInstanceOf('\coverallskit\entity\ServiceEntity');
            });
            it('should set the repository', function() {
                expect($this->configration->getRepository())->toBeAnInstanceOf('\coverallskit\entity\RepositoryEntity');
            });
        });
    });

    describe('applyTo', function() {
        beforeEach(function() {
            $this->rootDirectory = realpath(__DIR__ . '/../');
            $this->tmpDirectory = $this->rootDirectory . '/spec/tmp/';
            $this->fixtureDirectory = $this->rootDirectory . '/spec/fixtures/';
            $this->cloverReportFile = $this->tmpDirectory . 'clover.xml';

            $content = file_get_contents($this->fixtureDirectory . 'clover.xml');
            $content = sprintf($content, $this->rootDirectory, $this->rootDirectory);

            file_put_contents($this->cloverReportFile, $content);

            $config = new Config([
                'reportFile' => [
                    'input' => [
                        'type' => 'clover',
                        'file' => 'spec/tmp/clover.xml'
                    ],
                    'output' => 'coveralls.json'
                ],
                'token' => 'api-token',
                'service' => 'travis-ci',
                'repository' => __DIR__ . '/../'
            ]);

            $this->configration = new Configuration($config);

            $this->builder = new CoverallsReportBuilder();
            $this->configration->applyTo($this->builder);

            $this->report = $this->builder->build();
        });
        it('apply report name config', function() {
            expect($this->report->getName())->toEqual(realpath(__DIR__ . '/../') . '/coveralls.json');
        });
        it('apply service config', function() {
            expect($this->report->getService())->toBeAnInstanceOf('coverallskit\entity\ServiceEntity');
        });
        it('apply repository config', function() {
            expect($this->report->getRepository())->toBeAnInstanceOf('coverallskit\entity\RepositoryEntity');
        });
        it('apply clover report config', function() {
            $sourceFiles = $this->report->getSourceFiles();
            expect($sourceFiles->isEmpty())->toBeFalse();
        });
    });

    describe('loadFromFile', function() {
        context('when the file exists', function() {
            context('when .toml', function() {
                beforeEach(function() {
                    $this->config = Configuration::loadFromFile(__DIR__ . '/fixtures/coveralls.toml');
                });
                it('should return coverallskit\Configuration instance', function() {
                    expect($this->config)->toBeAnInstanceOf('coverallskit\Configuration');
                });
                it('should configration has report name', function() {
                    $path = realpath(__DIR__  . '/fixtures') . '/coveralls.json';
                    expect($this->config->getReportFileName())->toEqual($path);
                });
            });
        });
        context('when the file not exists', function() {
            it('should throw coverallskit\exception\FileNotFoundException', function() {
                expect(function() {
                    Configuration::loadFromFile(__DIR__ . '/fixtures/not_found_coveralls.yml');
                })->toThrow('coverallskit\exception\FileNotFoundException');
            });
        });
        context('when the file not support', function() {
            it('should throw coverallskit\exception\NotSupportFileTypeException', function() {
                expect(function() {
                    Configuration::loadFromFile(__DIR__ . '/fixtures/coveralls.ini');
                })->toThrow('coverallskit\exception\NotSupportFileTypeException');
            });
        });
    });

});
