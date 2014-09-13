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
     * @param string $reportContent
     * @return Result
     */
    public function parse($reportContent)
    {
        $this->reportContent = $reportContent;
        $lines = explode(PHP_EOL, $this->reportContent);

        $sourceFile = null;
        $sourceCollection = new SourceFileCollection();
        $parseErrors = new ExceptionCollection();
        $coverages = [];

        foreach ($lines as $line) {
            if (preg_match('/SF:/', $line) === 1) {
                $name = preg_replace('/^SF:(.+)$/', '$1', $line);
                $sourceFile = new SourceFile($name);
                $coverages = [];
            } else if (preg_match('/end_of_record/', $line) === 1) {
                try {
                    $sourceFile->getCoverages()->addAll($coverages);
                } catch (ExceptionCollection $exception) {
                    $parseErrors->merge($exception);
                }
                $sourceCollection->add($sourceFile);
            } else if (preg_match('/DA:/', $line) === 1) {
                $line = preg_replace('/DA:/', '', $line);
                $params = explode(',', $line);
                list($lineNumber, $executeCount) = $params;

                $lineNumber = (int) $lineNumber;
                $analysisResult = ((int) $executeCount >= 1) ? Coverage::EXECUTED : Coverage::UNUSED;

                $coverages[] = new Coverage($lineNumber, $analysisResult);
            }
        }

        return new Result($sourceCollection, $parseErrors);
    }

}
