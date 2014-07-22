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

class NotSupportFileTypeException extends UnexpectedValueException
{

    public function __construct($path, $code = 0, Exception $previous = null)
    {
        $result = preg_match("/.+(\..+)$/", $path, $matches);
        $fileType = ($result === 1) ? array_pop($matches) : $path;

        parent::__construct("The $fileType file type is not supported.", $code, $previous);
    }

}
