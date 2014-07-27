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

use coverallskit\ConfigurationLoader;

describe('ConfigurationLoader', function() {

    describe('loadFromFile', function() {
        before(function() {
            $this->loader = new ConfigurationLoader();
        });
        context('when the file exists', function() {
            context('when .yml', function() {
                before(function() {
                    $this->config = $this->loader->loadFromFile(__DIR__ . '/fixtures/coveralls.yml');
                });
                it('should return coverallskit\Configuration instance', function() {
                    expect($this->config)->toBeAnInstanceOf('coverallskit\Configuration');
                });
                it('should configration has report name', function() {
                    expect($this->config->getReportFileName())->toEqual(__DIR__  . '/fixtures/coveralls.json');
                });
            });
            context('when .yaml', function() {
                before(function() {
                    $this->config = $this->loader->loadFromFile(__DIR__ . '/fixtures/coveralls.yaml');
                });
                it('should return coverallskit\Configuration instance', function() {
                    expect($this->config)->toBeAnInstanceOf('coverallskit\Configuration');
                });
                it('should configration has report name', function() {
                    expect($this->config->getReportFileName())->toEqual(__DIR__  . '/fixtures/coveralls.json');
                });
            });
        });
        context('when the file not exists', function() {
            it('should throw coverallskit\exception\FileNotFoundException', function() {
                expect(function() {
                    $this->loader->loadFromFile(__DIR__ . '/fixtures/not_found_coveralls.yml');
                })->toThrow('coverallskit\exception\FileNotFoundException');
            });
        });
        context('when the file not support', function() {
            it('should throw coverallskit\exception\NotSupportFileTypeException', function() {
                expect(function() {
                    $this->loader->loadFromFile(__DIR__ . '/fixtures/coveralls.ini');
                })->toThrow('coverallskit\exception\NotSupportFileTypeException');
            });
        });
    });

});