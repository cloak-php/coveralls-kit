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

use coverallskit\report\ReportParserInterface;
use coverallskit\entity\SourceFile;
use coverallskit\entity\collection\SourceFileCollection;
use coverallskit\entity\Coverage;
use Zend\Dom\Query;
use Zend\Dom\NodeList;
use coverallskit\exception\ExceptionCollection;
use coverallskit\exception\LineOutOfRangeException;
use DOMElement;


/**
 * Class CloverReportParser
 * @package coverallskit\report\parser
 */
class CloverReportParser implements ReportParserInterface
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
     * @var CoverageCollection
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
        $this->sourceCollection = new SourceFileCollection();
        $this->reportParseErrors = new ExceptionCollection();
    }


    /**
     * @param string $reportContent
     * @return Result
     */
    public function parse($reportContent)
    {
        $this->reportContent = $reportContent;

        $files = $this->findFiles();
        return $this->parseFileNodes($files);
    }

    /**
     * @return NodeList
     */
    private function findFiles()
    {
        $query = new Query($this->reportContent);
        return $query->execute('file');
    }

    /**
     * @param string $fileName
     * @return NodeList
     */
    private function findCoverages($fileName)
    {
        $query = new Query($this->reportContent);
        return $query->execute("file[name='$fileName'] line");
    }

    /**
     * @param NodeList $files
     * @return Result
     */
    private function parseFileNodes(NodeList $files)
    {
        foreach($files as $file) {
            $fileName = (string) $file->getAttribute('name');

            $this->source = new SourceFile($fileName);

            $lines = $this->findCoverages($fileName);
            $this->parseLineNodes($lines);
        }

        $result = new Result(
            $this->sourceCollection,
            $this->reportParseErrors
        );

        return $result;
    }

    /**
     * @param NodeList $lines
     */
    private function parseLineNodes(NodeList $lines)
    {
        $this->coverages = $this->source->getEmptyCoverages();
        $this->coveragesErrors = new ExceptionCollection($this->source->getName());

        foreach ($lines as $line) {
            $this->parseLine($line);
        }

        $this->source->addCoverages($this->coverages);
        $this->sourceCollection->add($this->source);

        $this->reportParseErrors->merge($this->coveragesErrors);
    }

    /**
     * @param $line
     */
    private function parseLine(DOMElement $line)
    {
        $lineNumber = (int) $line->getAttribute('num');
        $executeCount = (int) $line->getAttribute('count');

        $analysisResult = ($executeCount >= 1)
            ? Coverage::EXECUTED : Coverage::UNUSED;

        $coverage = new Coverage($lineNumber, $analysisResult);

        try {
            $this->coverages->add($coverage);
        } catch (LineOutOfRangeException $exception) {
            $this->coveragesErrors->add($exception);
        }
    }

}
