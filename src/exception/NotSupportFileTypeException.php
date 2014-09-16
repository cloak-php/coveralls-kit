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

/**
 * Class NotSupportFileTypeException
 * @package coverallskit\exception
 */
class NotSupportFileTypeException extends UnexpectedValueException
{

    /**
     * @param string $path
     * @param int $code
     * @param Exception $previous
     */
    public function __construct($path, $code = 0, Exception $previous = null)
    {
        $filePath = $path;
        $fileType = preg_replace('/.+(\..+)$/', '$1', $filePath);

        parent::__construct("The '$fileType' file type is not supported.", $code, $previous);
    }

}
