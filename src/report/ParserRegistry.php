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

use coverallskit\Registry;


/**
 * Class ParserRegistry
 * @package coverallskit\report
 */
class ParserRegistry extends Registry
{

    /**
     * @param string $parserType
     */
    public function __construct()
    {
        $this->register('clover', '\coverallskit\report\parser\CloverReportParser');
    }

}
