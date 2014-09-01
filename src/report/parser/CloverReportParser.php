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
use coverallskit\exception\LineOutOfRangeException;
use coverallskit\exception\ExceptionCollection;


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
        $parseErrors = new ExceptionCollection();
        $sources = new SourceFileCollection();

        foreach($files as $file) {
            $fileName = (string) $file->getAttribute('name');

            $source = new SourceFile($fileName);

            $lines = $this->findCoverages($fileName);
            $coverages = $this->parseLineNodes($lines);

            try {
                $source->getCoverages()->addAll($coverages);
            } catch (ExceptionCollection $exception) {
                $parseErrors = $exception;
            }
        }

        $result = new Result($sources, $parseErrors);

        return $result;
    }

    /**
     * @param NodeList $lines
     * @return array
     */
    private function parseLineNodes(NodeList $lines)
    {
        $coverages = [];

        foreach ($lines as $line) {
            $lineNumber = (int) $line->getAttribute('num');
            $analysisResult = (int) $line->getAttribute('count');

            $coverage = new Coverage($lineNumber, $analysisResult);
            $coverages[] = $coverage;
        }

        return $coverages;
    }

}
