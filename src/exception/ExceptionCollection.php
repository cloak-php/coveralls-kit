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

class ExceptionCollection extends Exception
{

    /**
     * @var array
     */
    private $exceptions;

    public  function __construct($message = '', $code = 0, Exception $previous = null)
    {
        $this->exceptions = [];
        parent::__construct($message, $code, $previous);
    }

}
