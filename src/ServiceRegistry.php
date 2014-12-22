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
use coverallskit\exception\NotSupportServiceException;


/**
 * Class ServiceRegistry
 * @package coverallskit
 */
class ServiceRegistry
{

    /**
     * @var Registry
     */
    private $registry;


    public function __construct()
    {
        $this->registry = new Registry();
        $this->registry->register('travis-ci', 'coverallskit\entity\service\travis\TravisCI');
        $this->registry->register('travis-pro', 'coverallskit\entity\service\travis\TravisPro');
        $this->registry->register('drone.io', 'coverallskit\entity\service\DroneIO');
        $this->registry->register('circle-ci', 'coverallskit\entity\service\CircleCI');
    }

    /**
     * @param string $name
     * @return \coverallskit\entity\service\ServiceInterface
     */
    public function get($name)
    {
        try {
            $instance = $this->registry->get($name, [ new Environment($_SERVER) ]);
        } catch (RegistryNotFoundException $exception) {
            throw new NotSupportServiceException($name);
        }

        return $instance;
    }

}
