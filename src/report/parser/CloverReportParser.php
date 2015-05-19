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

use coverallskit\report\ReportParser;
use coverallskit\entity\SourceFile;
use coverallskit\entity\collection\SourceFileCollection;
use coverallskit\entity\CoverageResult;
use Symfony\Component\DomCrawler\Crawler;
use coverallskit\exception\ExceptionCollection;
use coverallskit\exception\LineOutOfRangeException;


/**
 * Class CloverReportParser
 * @package coverallskit\report\parser
 */
class CloverReportParser implements ReportParser
{
    /**
     * @var \Symfony\Component\DomCrawler\Crawler
     */
    private $crawler;

    /**
     * @var \coverallskit\entity\SourceFile
     */
    private $source;

    /**
     * @var \coverallskit\entity\collection\SourceFileCollection
     */
    private $sourceCollection;

    /**
     * @var \coverallskit\entity\collection\CoverageCollection
     */
    private $coverages;

    /**
     * @var ExceptionCollection
     */
    private $coveragesErrors;

    /**
     * @var ExceptionCollection
     */
    private $reportParseErrors;

    public function __construct()
    {
        $this->crawler = new Crawler();
        $this->sourceCollection = new SourceFileCollection();
        $this->reportParseErrors = new ExceptionCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function parse($reportFilePath)
    {
        $reportContent = file_get_contents($reportFilePath);

        $this->crawler->addXmlContent($reportContent);
        $fileNodes = $this->crawler->filter('file');

        return $this->parseFileNodes($fileNodes);
    }

    /**
     * @param Crawler $files
     * @return Result
     */
    private function parseFileNodes(Crawler $files)
    {
        $fileNodeParser = function(Crawler $file) {
            $fileName = $file->attr('name');

            $this->source = new SourceFile($fileName);
            $lines = $this->crawler->filter("file[name='$fileName'] line");

            $this->parseLineNodes($lines);
        };
        $fileNodeParser->bindTo($this);

        $files->each($fileNodeParser);

        $result = new Result(
            $this->sourceCollection,
            $this->reportParseErrors
        );

        return $result;
    }

    /**
     * @param Crawler $lines
     */
    private function parseLineNodes(Crawler $lines)
    {
        $this->coverages = $this->source->getEmptyCoverages();
        $this->coveragesErrors = new ExceptionCollection($this->source->getName());

        $lineNodeParser = function(Crawler $line) {
            $this->parseLine($line);
        };
        $lineNodeParser->bindTo($this);

        $lines->each($lineNodeParser);

        $this->source->addCoverages($this->coverages);
        $this->sourceCollection->add($this->source);

        $this->reportParseErrors->merge($this->coveragesErrors);
    }

    /**
     * @param Crawler $line
     */
    private function parseLine(Crawler $line)
    {
        $lineNumber = (int) $line->attr('num');
        $executeCount = (int) $line->attr('count');

        $analysisResult = ($executeCount >= 1)
            ? CoverageResult::EXECUTED : CoverageResult::UNUSED;

        $coverage = new CoverageResult($lineNumber, $analysisResult);

        try {
            $this->coverages->add($coverage);
        } catch (LineOutOfRangeException $exception) {
            $this->coveragesErrors->add($exception);
        }
    }

}
