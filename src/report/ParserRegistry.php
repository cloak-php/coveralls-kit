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
class ParserRegistry
{
    /**
     * @var Registry
     */
    private $registry;

    public function __construct()
    {
        $this->registry = new Registry();
        $this->registry->register('clover', '\coverallskit\report\parser\CloverReportParser');
        $this->registry->register('lcov', '\coverallskit\report\parser\LcovReportParser');
    }

    /**
     * @param $name
     * @return \coverallskit\report\ReportParserInterface
     * @throws \coverallskit\exception\RegistryNotFoundException
     */
    public function get($name)
    {
        return $this->registry->get($name);
    }

}
