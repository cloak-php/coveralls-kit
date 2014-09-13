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
use coverallskit\report\lcov\EndOfRecord;
use coverallskit\report\lcov\SourceFile as LcovSourceFile;
use coverallskit\report\lcov\Coverage as LcovCoverage;
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
    private $source;

    /**
     * @var SourceFileCollection
     */
    private $sourceCollection;

    /**
     * @var array
     */
    private $coverages;

    /**
     * @var ExceptionCollection
     */
    private $parseErrors;

    public function __construct()
    {
        $this->parseErrors = new ExceptionCollection();
        $this->sourceCollection = new SourceFileCollection();
    }

    /**
     * @param string $reportContent
     * @return Result
     */
    public function parse($reportContent)
    {
        $this->reportContent = $reportContent;
        $lines = explode(PHP_EOL, $this->reportContent);

        foreach ($lines as $line) {
            if (LcovSourceFile::match($line)) {
                $this->startSource($line);
            } else if (EndOfRecord::match($line)) {
                $this->endSource();
            } else if (LcovCoverage::match($line)) {
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
        $source = new LcovSourceFile($line);
        $this->source = new SourceFile($source->getName());
        $this->coverages = [];
    }

    private function endSource()
    {
        try {
            $this->source->getCoverages()->addAll($this->coverages);
        } catch (ExceptionCollection $exception) {
            $this->parseErrors->merge($exception);
        }
        $this->sourceCollection->add($this->source);
    }

    /**
     * @param string $line
     */
    private function coverage($line)
    {
        $coverage = new LcovCoverage($line);
        $this->coverages[] = $coverage->toEntity();
    }

}
