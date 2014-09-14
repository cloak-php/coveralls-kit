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


describe('Report', function() {
    before(function() {
        $this->configDirectory = __DIR__ . '/../fixtures/';

        $this->rootConfig = new Configuration([
            Configuration::CONFIG_DIRECTORY_KEY => $this->configDirectory
        ]);

        $configValues = [
            Report::INPUT_REPORT_FILE_KEY => [
                Report::INPUT_REPORT_FILE_TYPE_KEY => 'lcov',
                Report::INPUT_REPORT_FILE_PATH_KEY => 'report.lcov',
            ],
            Report::OUTPUT_REPORT_FILE_KEY => 'report.json'
        ];
        $reportConfig = new Config($configValues);

        $this->reportConfig = new Report($reportConfig, $this->rootConfig);
    });
    describe('getReportFileName', function() {
        before(function() {
            $this->directory = realpath($this->configDirectory) . DIRECTORY_SEPARATOR;
            $this->reportFile = $this->directory . 'report.json';
        });
        it('return report file path', function() {
            expect($this->reportConfig->getReportFileName())->toEqual($this->reportFile);
        });
    });
    describe('getCoverageReportFileType', function() {
        it('return cpverage report type', function() {
            expect($this->reportConfig->getCoverageReportFileType())->toEqual('lcov');
        });
    });
    describe('getCoverageReportFilePath', function() {
        before(function() {
            $this->directory = realpath($this->configDirectory) . DIRECTORY_SEPARATOR;
            $this->reportFile = $this->directory . 'report.lcov';
        });
        it('return cpverage report type', function() {
            expect($this->reportConfig->getCoverageReportFilePath())->toEqual($this->reportFile);
        });
    });
    describe('applyTo', function() {
        before(function() {
            $this->directory = realpath($this->configDirectory) . DIRECTORY_SEPARATOR;
            $this->reportFile = $this->directory . 'report.json';

            $this->reportBuilder = new ReportBuilder();
            $this->reportConfig->applyTo($this->reportBuilder);
        });
        it('apply report file configration', function() {
            expect($this->reportBuilder->reportFilePath)->toEqual($this->reportFile);
        });
    });
});

