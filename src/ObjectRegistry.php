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
 * Class ObjectRegistry
 */
class ObjectRegistry
{
    /**
     * @var array
     */
    private $reflections = [];

    public function __construct()
    {
        $this->reflections = [];
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     *
     * @throws exception\RegistryNotFoundException
     */
    public function get($name, array $arguments = [])
    {
        if (array_key_exists($name, $this->reflections) === false) {
            throw new RegistryNotFoundException("$name not found registry");
        }

        $reflection = $this->reflections[$name];

        return $reflection->newInstanceArgs($arguments);
    }

    /**
     * @param string $name
     * @param string $class
     */
    public function register($name, $class)
    {
        $reflection = new ReflectionClass($class);
        $this->reflections[$name] =  $reflection;
    }
}
