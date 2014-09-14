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

use coverallskit\ReportBuilder;
use coverallskit\Configuration;
use coverallskit\configuration\Report;
use Zend\Config\Config;
use Eloquent\Pathogen\Factory\PathFactory;


describe('Report', function() {
    before(function() {
        $this->rootDirectory = realpath(__DIR__ . '/../../');
        $this->configDirectory = __DIR__ . '/../fixtures/';
        $this->tmpDirectory = $this->rootDirectory . '/spec/tmp/';
        $this->fixtureDirectory = $this->rootDirectory . '/spec/fixtures/';
        $this->cloverReportFile = $this->tmpDirectory . 'clover.xml';

//        $this->rootConfig = new Configuration([
  //          Configuration::CONFIG_DIRECTORY_KEY => $this->configDirectory
    //    ]);

        $factory = PathFactory::instance();
        $rootPath = $factory->create($this->configDirectory);


        $configValues = [
            Report::INPUT_REPORT_FILE_KEY => [
                Report::INPUT_REPORT_FILE_TYPE_KEY => 'clover',
                Report::INPUT_REPORT_FILE_PATH_KEY => '../tmp/clover.xml',
            ],
            Report::OUTPUT_REPORT_FILE_KEY => '../tmp/report.json'
        ];
        $reportConfig = new Config($configValues);

        $this->reportConfig = new Report($reportConfig, $rootPath);
    });
    describe('getReportFileName', function() {
        before(function() {
            $this->reportFile = $this->tmpDirectory . 'report.json';
        });
        it('return report file path', function() {
            expect($this->reportConfig->getReportFileName())->toEqual($this->reportFile);
        });
    });
    describe('getCoverageReportFileType', function() {
        it('return cpverage report type', function() {
            expect($this->reportConfig->getCoverageReportFileType())->toEqual('clover');
        });
    });
    describe('getCoverageReportFilePath', function() {
        it('return cpverage report type', function() {
            expect($this->reportConfig->getCoverageReportFilePath())->toEqual($this->cloverReportFile);
        });
    });
    describe('applyTo', function() {
        before(function() {
            $content = file_get_contents($this->fixtureDirectory . 'clover.xml');
            $content = sprintf($content, $this->rootDirectory, $this->rootDirectory);

            file_put_contents($this->cloverReportFile, $content);

            $this->reportFile = $this->tmpDirectory . 'report.json';
            $this->reportBuilder = new ReportBuilder();
            $this->reportConfig->applyTo($this->reportBuilder);
        });
        it('apply report file configration', function() {
            expect($this->reportBuilder->reportFilePath)->toEqual($this->reportFile);
        });
        it('apply coverage report configration', function() {
            $sourceFiles = $this->reportBuilder->sourceFiles;
            expect($sourceFiles->isEmpty())->toBeFalse();
        });
    });
});
