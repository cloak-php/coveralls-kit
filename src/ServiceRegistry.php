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


use coverallskit\exception\NotSupportServiceException;
use coverallskit\entity\Service;
use coverallskit\environment\TravisCI;
use coverallskit\environment\TravisPro;
use coverallskit\environment\CircleCI;
use coverallskit\environment\DroneIO;
use PhpCollection\Map;


/**
 * Class ServiceRegistry
 * @package coverallskit
 */
class ServiceRegistry
{

    /**
     * @var \PhpCollection\Map
     */
    private $registry;


    public function __construct()
    {
        $environment = new Environment($_SERVER);

        $this->registry = new Map();
        $this->registry->set('travis-ci', new Service(new TravisCI($environment)));
        $this->registry->set('travis-pro', new Service(new TravisPro($environment)));
        $this->registry->set('circle-ci', new Service(new CircleCI($environment)));
        $this->registry->set('drone.io', new Service(new DroneIO($environment)));
    }

    /**
     * @param string $name
     * @return \coverallskit\entity\ServiceInterface
     */
    public function get($name)
    {
        $instance = $this->registry->get($name);

        if ($instance->isEmpty()) {
            throw new NotSupportServiceException($name);
        }

        return $instance->get();
    }

}
