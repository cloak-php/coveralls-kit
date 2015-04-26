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
use coverallskit\report\parser\CloverReportParser;
use coverallskit\report\parser\LcovReportParser;

/**
 * Class ParserRegistry
 * @package coverallskit\report
 */
class ParserRegistry
{
    /**
     * @var Registry
     */
    private $registry;

    public function __construct()
    {
        $this->registry = new Registry();
        $this->registry->register('clover', CloverReportParser::class);
        $this->registry->register('lcov', LcovReportParser::class);
    }

    /**
     * @param string $name
     * @return \coverallskit\report\ReportParser
     * @throws \coverallskit\exception\RegistryNotFoundException
     */
    public function get($name)
    {
        return $this->registry->get($name);
    }

}
