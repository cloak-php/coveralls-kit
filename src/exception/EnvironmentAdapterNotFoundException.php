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

use UnexpectedValueException;

/**
 * Class EnvironmentAdapterNotFoundException
 */
class EnvironmentAdapterNotFoundException extends UnexpectedValueException
{
    /**
     * @param string $name
     *
     * @return EnvironmentAdapterNotFoundException
     */
    public static function createByName($name)
    {
        $template = 'Does not support the environment %s.';
        $message = sprintf($template, $name);

        return new self($message);
    }
}
