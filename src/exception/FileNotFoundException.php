<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coveralls\exception;

use Exception;
use UnexpectedValueException;

class FileNotFoundException extends UnexpectedValueException
{

    public function __construct($path, $code = 0, Exception $previous = null)
    {
        parent::__construct("Can not find the file $path", $code, $previous);
    }

}
