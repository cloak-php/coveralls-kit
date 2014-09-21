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

class NotSupportServiceException extends UnexpectedValueException
{

    public function __construct($serviceName, $code = 0, Exception $previous = null)
    {
        parent::__construct("The '$serviceName' is not supported.", $code, $previous);
    }

}
