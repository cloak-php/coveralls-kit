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
use Zend\Config\Config;


/**
 * Class Report
 * @package coverallskit\configuration
 */
class Report extends AbstractConfiguration
{

    const INPUT_REPORT_FILE_KEY = 'input';
    const INPUT_REPORT_FILE_TYPE_KEY = 'type';
    const INPUT_REPORT_FILE_PATH_KEY = 'file';
    const OUTPUT_REPORT_FILE_KEY = 'output';

    /**
     * @return \Zend\Config\Config
     */
    private function getCodeCoverageReport()
    {
        $reportFileType = $this->get(self::INPUT_REPORT_FILE_KEY);
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
        $path = $this->get(self::OUTPUT_REPORT_FILE_KEY);
        return $this->resolvePath($path);
    }

    /**
     * @return string
     */
    public function getCoverageReportFilePath()
    {
        $reportFileType = $this->getCodeCoverageReport();
        $filePath = $reportFileType->get(self::INPUT_REPORT_FILE_PATH_KEY, '');

        return $this->resolvePath($filePath);
    }

    /**
     * @param ReportBuilderInterface $builder
     * FIXME throw exception
     */
    private function applyReportResult(ReportBuilderInterface $builder)
    {
        $path = $this->getCoverageReportFilePath();
        $reportType = $this->getCoverageReportFileType();

        if (file_exists($path) === false) {
            return;
        }

        if (is_null($reportType)) {
            return;
        }

        $registry = new ParserRegistry();
        $parser = $registry->get($reportType);
        $parseResult = $parser->parse(file_get_contents($path));

        $builder->addSources($parseResult->getSources());

        return $builder;
    }

    /**
     * @param ReportBuilderInterface $builder
     * @return ReportBuilderInterface
     */
    public function applyTo(ReportBuilderInterface $builder)
    {
        $builder->reportFilePath($this->getReportFileName());
        return $this->applyReportResult($builder);
    }

}
