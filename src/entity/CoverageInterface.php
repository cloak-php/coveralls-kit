<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coveralls\entity;

interface CoverageInterface
{

    const UNUSED = 0;
    const EXECUTED = 1;

    /**
     * @return integer
     */
    public function getLineNumber();

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
