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
            it('should return coverallskit\Configuration instance', function() {
                $config = $this->loader->loadFromFile(__DIR__ . '/fixtures/coveralls.yml');
                expect($config)->toBeAnInstanceOf('coverallskit\Configuration');
            });
        });
        context('when the file not exists', function() {
            it('should throw coverallskit\exception\FileNotFoundException', function() {
                expect(function() {
                    $this->loader->loadFromYamlFile(__DIR__ . '/fixtures/not_found_coveralls.yml');
                })->toThrow('coverallskit\exception\FileNotFoundException');
            });
        });
    });

    describe('loadFromYamlFile', function() {
        before(function() {
            $this->loader = new ConfigurationLoader();
        });
        context('when the file exists', function() {
            it('should return coverallskit\Configuration instance', function() {
                $config = $this->loader->loadFromYamlFile(__DIR__ . '/fixtures/coveralls.yml');
                expect($config)->toBeAnInstanceOf('coverallskit\Configuration');
            });
        });
        context('when the file not exists', function() {
            it('should throw coverallskit\exception\FileNotFoundException', function() {
                expect(function() {
                    $this->loader->loadFromYamlFile(__DIR__ . '/fixtures/not_found_coveralls.yml');
                })->toThrow('coverallskit\exception\FileNotFoundException');
            });
        });
    });

});
