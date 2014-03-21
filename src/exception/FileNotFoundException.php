<?php

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
