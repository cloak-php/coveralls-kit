<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace coverallskit\entity;

use coverallskit\value\LineRange;

/**
 * Interface CoverageEntity
 */
interface CoverageEntity
{
    const UNUSED = 0;
    const EXECUTED = 1;

    /**
     * @return integer
     */
    public function getLineNumber();

    /**
     * @return int
     */
    public function getAnalysisResult();

    /**
     * @param LineRange $lineRange
     *
     * @return bool
     */
    public function contains(LineRange $lineRange);

    /**
     * @return boolean
     */
    public function isUnused();

    /**
     * @return boolean
     */
    public function isExecuted();

    /**
     * @return integer|null
     */
    public function valueOf();
}
