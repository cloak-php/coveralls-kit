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

use ReflectionClass;
use ReflectionException;

/**
 * Class ServiceRegistry
 * @package coverallskit
 */
class ServiceRegistry
{

    /**
     * @var array
     */
    private $services;


    public function __construct()
    {
        $this->registerService('travis-ci', 'coverallskit\entity\service\travis\TravisCI');
        $this->registerService('travis-pro', 'coverallskit\entity\service\travis\TravisPro');
    }

    /**
     * @param string $name
     * @return \coverallskit\entity\service\ServiceInterface
     */
    public function get($name)
    {
        if (array_key_exists($name, $this->services) === false) {
            //FIXME throw exception
            return null;
        }

        $reflection = $this->services[$name];

        return $reflection->newInstanceArgs([ new Environment($_SERVER) ]);
    }

    /**
     * @param string $name
     * @param string $serviceClass
     */
    protected function registerService($name, $serviceClass)
    {
        try {
            $reflection = new ReflectionClass($serviceClass);
        } catch (ReflectionException $exception) {
            //FIXME throw exception
        }

        $this->services[$name] = $reflection;
    }

}
