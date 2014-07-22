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
 * Class Env
 * @package coverallskit
 */
class Env
{

    /**
     * @var array
     */
    private $env;

    /**
     * @param array $env
     */
    public function __construct(array $env = array())
    {
        $this->env = $env;
    }

    /**
     * @param string $key
     */
    public function get($key)
    {
        if (array_key_exists($key, $this->env) === false) {
            return null;
        }

        return $this->env[$key];
    }

}
