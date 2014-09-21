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
 * Interface ReportParserInterface
 * @package coverallskit\report
 */
interface ReportParserInterface
{

    /**
     * @param $reportContent
     * @return \coverallskit\report\parser\Result
     */
    public function parse($reportContent);

}
