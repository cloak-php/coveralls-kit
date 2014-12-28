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

use Exception;
use UnexpectedValueException;

class RequiredException extends UnexpectedValueException
{

    /**
     * @param string $valueName
     * @param int $code
     * @param Exception $previous
     */
    public function __construct($valueName, $code = 0, Exception $previous = null)
    {
        parent::__construct("'$valueName' of the report is required.", $code, $previous);
    }

}
