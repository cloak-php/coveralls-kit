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
use coverallskit\report\lcov\RecordLexer;
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
        $recordLexer = new RecordLexer($reportContent);

        foreach ($recordLexer as $record) {
            if ($record instanceof LcovSourceFile) {
                $this->startSource($record);
            } elseif ($record instanceof EndOfRecord) {
                $this->endSource();
            } elseif ($record instanceof LcovCoverage) {
                $this->coverage($record);
            }
        }

        return new Result($this->sourceCollection, $this->parseErrors);
    }

    /**
     * @param LcovSourceFile $source
     */
    private function startSource(LcovSourceFile $source)
    {
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
     * @param LcovCoverage $coverage
     */
    private function coverage(LcovCoverage $coverage)
    {
        $this->coverages[] = $coverage->toEntity();
    }

}
