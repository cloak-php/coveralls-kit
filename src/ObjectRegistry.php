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

use Collections\Dictionary;
use coverallskit\exception\RegistryNotFoundException;
use ReflectionClass;

/**
 * Class ObjectRegistry
 */
class ObjectRegistry
{
    /**
     * @var \Collections\Dictionary
     */
    private $reflections;

    public function __construct()
    {
        $this->reflections = new Dictionary;
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
        if ($this->reflections->containsKey($name) === false) {
            throw new RegistryNotFoundException("$name not found registry");
        }

        $reflection = $this->reflections->get($name);

        return $reflection->newInstanceArgs($arguments);
    }

    /**
     * @param string $name
     * @param string $class
     */
    public function register($name, $class)
    {
        $reflection = new ReflectionClass($class);
        $this->reflections->add($name, $reflection);
    }
}
