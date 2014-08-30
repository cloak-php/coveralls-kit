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
use Exception;


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
     * @param string $reportFilePath
     */
    public function __construct($reportFilePath)
    {
        $this->reportContent = file_get_contents($reportFilePath);
    }

    /**
     * @return SourceFileCollection
     */
    public function parse()
    {
        $query = new Query($this->reportContent);
        $files = $query->execute('file');

        return $this->parseFileNodes($files);
    }

    /**
     * @param NodeList $files
     * @return SourceFileCollection
     */
    private function parseFileNodes(NodeList $files)
    {
        $sources = new SourceFileCollection();

        foreach($files as $file) {
            $fileName = (string) $file->getAttribute('name');
            $source = new SourceFile($fileName);

            $query = new Query($this->reportContent);
            $lines = $query->execute("file[name='$fileName'] line");

            $coverages = static::parseLineNodes($lines);

            try {
                $source->getCoverages()->addAll($coverages);
            } catch (Exception $e) {

            }
        }

        return $sources;
    }


    /**
     * @param NodeList $lines
     * @return array
     */
    private static function parseLineNodes(NodeList $lines)
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
