<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\exception;

use coverallskit\value\LineRange;
use coverallskit\entity\CoverageEntitiy;
use Exception;
use OutOfRangeException;

class LineOutOfRangeException extends OutOfRangeException
{

    public function __construct(CoverageEntitiy $coverage, LineRange $range, $code = 0, Exception $previous = null)
    {
        $template = "The %dst line is outside the range of the %dth line from the %dst line";
        $message = sprintf($template, $coverage->getLineNumber(), $range->getLastLineNumber(), $range->getFirstLineNumber());

        parent::__construct($message, $code, $previous);
    }

}
