<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\report\parser;

use coverallskit\entity\SourceFile;
use coverallskit\entity\collection\SourceFileCollection;
use coverallskit\entity\Coverage;
use coverallskit\entity\collection\CoverageCollection;
use coverallskit\report\ReportParserInterface;
use coverallskit\exception\ExceptionCollection;

/**
 * Class LcovReportParser
 * @package coverallskit\report\parser
 */
class LcovReportParser implements ReportParserInterface
{

    /**
     * @var string
     */
    private $reportContent;

    /**
     * @var SourceFile
     */
    private $currentSource;

    /**
     * @var SourceFileCollection
     */
    private $sourceCollection;

    /**
     * @var ExceptionCollection
     */
    private $parseErrors;

    /**
     * @var array
     */
    private $currentCoverages;


    /**
     * @param string $reportContent
     * @return Result
     */
    public function parse($reportContent)
    {
        $this->reportContent = $reportContent;
        $lines = explode(PHP_EOL, $this->reportContent);

        $this->sourceCollection = new SourceFileCollection();
        $this->parseErrors = new ExceptionCollection();

        foreach ($lines as $line) {
            if (preg_match('/SF:/', $line) === 1) {
                $this->startSource($line);
            } else if (preg_match('/end_of_record/', $line) === 1) {
                $this->endSource();
            } else if (preg_match('/DA:/', $line) === 1) {
                $this->coverage($line);
            }
        }

        return new Result($this->sourceCollection, $this->parseErrors);
    }

    /**
     * @param string $line
     */
    private function startSource($line)
    {
        $name = preg_replace('/^SF:(.+)$/', '$1', $line);
        $this->currentSource = new SourceFile($name);
        $this->currentCoverages = [];
    }

    private function endSource()
    {
        try {
            $this->currentSource->getCoverages()->addAll($this->currentCoverages);
        } catch (ExceptionCollection $exception) {
            $this->parseErrors->merge($exception);
        }
        $this->sourceCollection->add($this->currentSource);
    }

    /**
     * @param string $line
     */
    private function coverage($line)
    {
        $line = preg_replace('/DA:/', '', $line);
        $params = explode(',', $line);
        list($lineNumber, $executeCount) = $params;

        $lineNumber = (int) $lineNumber;
        $analysisResult = ((int) $executeCount >= 1) ? Coverage::EXECUTED : Coverage::UNUSED;

        $this->currentCoverages[] = new Coverage($lineNumber, $analysisResult);
    }

}
