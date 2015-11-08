<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace coverallskit;

/**
 * Class Environment
 */
class Environment
{
    /**
     * @var array
     */
    private $variables;

    /**
     * @param array $variables
     */
    public function __construct(array $variables = [])
    {
        $this->variables = $variables;
    }

    /**
     * @param string $key
     */
    public function get($key)
    {
        if (array_key_exists($key, $this->variables) === false) {
            return null;
        }

        return $this->variables[$key];
    }
}
