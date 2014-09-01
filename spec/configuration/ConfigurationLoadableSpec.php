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

use coverallskit\configuration\ConfigurationLoadable;
use coverallskit\ConfigurationLoaderInterface;
use coverallskit\Configuration;


class Loader implements ConfigurationLoaderInterface {
    use ConfigurationLoadable;
}

describe('ConfigurationLoadable', function() {

    describe('loadFromFile', function() {
        context('when the file exists', function() {
            context('when .yml', function() {
                before(function() {
                    $this->config = Loader::loadFromFile(__DIR__ . '/../fixtures/coveralls.yml');
                });
                it('should return coverallskit\Configuration instance', function() {
                    expect($this->config)->toBeAnInstanceOf('coverallskit\Configuration');
                });
                it('should configration has report name', function() {
                    $path = realpath(__DIR__  . '/../fixtures') . '/coveralls.json';
                    expect($this->config->getReportFileName())->toEqual($path);
                });
            });
            context('when .yaml', function() {
                before(function() {
                    $this->config = Loader::loadFromFile(__DIR__ . '/../fixtures/coveralls.yaml');
                });
                it('should return coverallskit\Configuration instance', function() {
                    expect($this->config)->toBeAnInstanceOf('coverallskit\Configuration');
                });
                it('should configration has report name', function() {
                    $path = realpath(__DIR__  . '/../fixtures') . '/coveralls.json';
                    expect($this->config->getReportFileName())->toEqual($path);
                });
            });
        });
        context('when the file not exists', function() {
            it('should throw coverallskit\exception\FileNotFoundException', function() {
                expect(function() {
                    Loader::loadFromFile(__DIR__ . '/../fixtures/not_found_coveralls.yml');
                })->toThrow('coverallskit\exception\FileNotFoundException');
            });
        });
        context('when the file not support', function() {
            it('should throw coverallskit\exception\NotSupportFileTypeException', function() {
                expect(function() {
                    Loader::loadFromFile(__DIR__ . '/../fixtures/coveralls.ini');
                })->toThrow('coverallskit\exception\NotSupportFileTypeException');
            });
        });
    });

});
