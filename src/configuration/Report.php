<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\configuration;

use coverallskit\Configuration;
use coverallskit\ReportBuilderInterface;
use Zend\Config\Config;

/**
 * Class Report
 * @package coverallskit\configuration
 */
class Report
{

    const INPUT_REPORT_FILE_KEY = 'input';
    const INPUT_REPORT_FILE_TYPE_KEY = 'type';
    const INPUT_REPORT_FILE_PATH_KEY = 'file';
    const OUTPUT_REPORT_FILE_KEY = 'output';

    /**
     * @var \Zend\Config\Config
     */
    private $reportConfig;

    /**
     * @var \coverallskit\Configuration
     */
    private $rootConfig;


    /**
     * @param Config $config
     */
    public function __construct(Config $reportConfig, Configuration $rootConfig)
    {
        $this->rootConfig = $rootConfig;
        $this->reportConfig = $reportConfig;
    }

    /**
     * @return \Zend\Config\Config
     */
    private function getCodeCoverageReport()
    {
        $reportFileType = $this->reportConfig->get(self::INPUT_REPORT_FILE_KEY);
        $reportFileType = $reportFileType ?: new Config([]);

        return $reportFileType;
    }

    /**
     * @return string
     */
    public function getCoverageReportFileType()
    {
        $reportFileType = $this->getCodeCoverageReport();
        $type = $reportFileType->get(self::INPUT_REPORT_FILE_TYPE_KEY);

        return $type;
    }

    /**
     * @return string
     */
    public function getReportFileName()
    {
        $path = $this->reportConfig->get(self::OUTPUT_REPORT_FILE_KEY);
        return $this->resolvePath($path);
    }

    /**
     * @return string
     */
    public function getCoverageReportFilePath()
    {
        $reportFileType = $this->getCodeCoverageReport();
        $filePath = $reportFileType->get(self::INPUT_REPORT_FILE_PATH_KEY);

        return $this->resolvePath($filePath);
    }

    /**
     * @param string $name
     * @return string
     */
    private function resolvePath($name)
    {
        $directoryPath = $this->rootConfig->getDirectoryPath();
        $relativePath = preg_replace('/^(\\/|\\.\\/)*(.+)/', '$2', $name);

        return $directoryPath . $relativePath;
    }

    /**
     * @param ReportBuilderInterface $builder
     * @return ReportBuilderInterface
     */
    public function applyTo(ReportBuilderInterface $builder)
    {
    }

}
