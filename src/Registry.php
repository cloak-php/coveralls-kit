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
class Registry
{

    /**
     * @var array
     */
    private $classReflections;

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws exception\RegistryNotFoundException
     */
    public function get($name, array $arguments = [])
    {
        if (isset($this->classReflections[$name]) === false) {
            throw new RegistryNotFoundException("$name not found registry");
        }

        $reflection = $this->classReflections[$name];

        return $reflection->newInstanceArgs($arguments);
    }

    /**
     * @param string $name
     * @param string $class
     */
    public function register($name, $class)
    {
        $reflection = new ReflectionClass($class);
        $this->classReflections[$name] = $reflection;
    }

}
