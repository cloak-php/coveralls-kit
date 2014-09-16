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
use coverallskit\report\ParserRegistry;
use coverallskit\exception\FileNotFoundException;
use coverallskit\exception\RegistryNotFoundException;
use coverallskit\exception\NotSupportFileTypeException;
use Zend\Config\Config;


/**
 * Class Report
 * @package coverallskit\configuration
 */
class Report extends AbstractConfiguration
{

    const REPORT_FILE_KEY = 'reportFile';
    const INPUT_REPORT_FILE_KEY = 'input';
    const INPUT_REPORT_FILE_TYPE_KEY = 'type';
    const INPUT_REPORT_FILE_PATH_KEY = 'file';
    const OUTPUT_REPORT_FILE_KEY = 'output';

    /**
     * @return \Zend\Config\Config
     */
    private function getCodeCoverageReport()
    {
        $fileType = $this->get(self::INPUT_REPORT_FILE_KEY);
        $fileType = (is_null($fileType)) ? new Config([]) : $fileType;
        return $fileType;
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
        $path = $this->get(self::OUTPUT_REPORT_FILE_KEY);
        return $this->resolvePath($path);
    }

    /**
     * @return string|null
     */
    public function getCoverageReportFilePath()
    {
        $fileType = $this->getCodeCoverageReport();
        $filePath = $fileType->get(self::INPUT_REPORT_FILE_PATH_KEY, null);

        if (is_null($filePath) === true) {
            return null;
        }

        return $this->resolvePath($filePath);
    }

    /**
     * @return bool
     */
    public function isCoverageReportEmpty()
    {
        $reportType = $this->getCoverageReportFileType();
        $reportFilePath = $this->getCoverageReportFilePath();
        return empty($reportType) || empty($reportFilePath);
    }

    /**
     * @param ReportBuilderInterface $builder
     */
    private function applyReportResult(ReportBuilderInterface $builder)
    {
        $path = $this->getCoverageReportFilePath();
        $reportType = $this->getCoverageReportFileType();

        if (file_exists($path) === false) {
            throw new FileNotFoundException($path);
        }

        $parser = $this->detectReportParser($reportType);
        $parseResult = $parser->parse(file_get_contents($path));

        $builder->addSources($parseResult->getSources());

        return $builder;
    }

    /**
     * @param string $reportType
     * @return \coverallskit\report\ReportParserInterface
     * @throws \coverallskit\exception\NotSupportFileTypeException
     */
    private function detectReportParser($reportType)
    {
        $registry = new ParserRegistry();

        try {
            $parser = $registry->get($reportType);
        } catch (RegistryNotFoundException $exception) {
            throw new NotSupportFileTypeException($reportType);
        }

        return $parser;
    }

    /**
     * @param ReportBuilderInterface $builder
     * @return ReportBuilderInterface
     */
    public function applyTo(ReportBuilderInterface $builder)
    {
        $builder->reportFilePath($this->getReportFileName());

        if ($this->isCoverageReportEmpty()) {
            return $builder;
        }

        return $this->applyReportResult($builder);
    }

}
