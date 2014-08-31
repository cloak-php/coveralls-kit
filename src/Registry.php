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

use coverallskit\exception\RegistryNotFoundException;
use ReflectionClass;


/**
 * Class Registry
 * @package coverallskit
 */
abstract class Registry
{

    /**
     * @var array
     */
    private $classReflections;

    /**
     * @param string $name
     */
    public function get($name)
    {
        if (isset($this->classReflections[$name]) === false) {
            throw new RegistryNotFoundException("$name not found registry");
        }

        $reflection = $this->classReflections[$name];

        return $reflection->newInstanceArgs();
    }

    /**
     * @param string $name
     * @param string $class
     */
    protected function register($name, $class)
    {
        $reflection = new ReflectionClass($class);
        $this->classReflections[$name] = $reflection;
    }

}
