<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace coverallskit\report;

/**
 * Interface ReportParser
 */
interface ReportParser
{
    /**
     * Parse the report file of the code coverage
     *
     * @param string $reportFilePath
     *
     * @return \coverallskit\report\parser\Result
     */
    public function parse($reportFilePath);
}
