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

    protected $lineCount = 1;

    /**
     * @param integer $lineCount
     */
    public function __construct($lineCount)
    {
        if ((int) $lineCount <= 0) {
            throw new OutOfRangeException('Can not use a specified number of lines');
        }
        $this->lineCount = $lineCount;
    }

    public function getFirstLineNumber()
    {
        return 1;
    }

    public function getLastLineNumber()
    {
        return $this->lineCount;
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
