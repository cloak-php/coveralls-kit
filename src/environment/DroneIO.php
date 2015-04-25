<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\environment;


/**
 * Class DroneIO
 * @package coverallskit\environment
 */
final class DroneIO extends AbstractAdaptor implements EnvironmentAdaptor
{

    const NAME = 'drone.io';
    const DRONE = 'DRONE';
    const DRONE_BUILD_NUMBER = 'DRONE_BUILD_NUMBER';


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function getBuildJobId()
    {
        return $this->environment->get(self::DRONE_BUILD_NUMBER);
    }

    /**
     * {@inheritdoc}
     */
    public function isSupported()
    {
        $value = $this->environment->get(self::DRONE);
        return $value === 'true';
    }

}
