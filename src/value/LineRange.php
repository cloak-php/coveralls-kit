<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\value;

use OutOfRangeException;

class LineRange
{

    protected $fromLineNumber = 1;
    protected $toLineNumber = 1;

    /**
     * @param integer $fromLineNumber
     * @param integer $toLineNumber
     */
    public function __construct($fromLineNumber, $toLineNumber)
    {
        if ((int) $fromLineNumber <= 0 || (int) $toLineNumber <= 0) {
            throw new OutOfRangeException('Can not use a specified number of lines');
        }

        if ((int) $fromLineNumber > (int) $toLineNumber) {
            throw new OutOfRangeException('Can not use a specified range of lines');
        }

        $this->fromLineNumber = (int) $fromLineNumber;
        $this->toLineNumber = (int) $toLineNumber;
    }

    public function getFirstLineNumber()
    {
        return $this->fromLineNumber;
    }

    public function getLastLineNumber()
    {
        return $this->toLineNumber;
    }

    /**
     * @param integer $lineAt
     * @return boolean
     */
    public function between($lineAt)
    {
        return $lineAt >= $this->getFirstLineNumber() && $lineAt <= $this->getLastLineNumber();
    }

    /**
     * @param integer $lineAt
     * @return boolean
     */
    public function contains($lineAt)
    {
        return $this->between($lineAt);
    }

}
