<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\entity\service;


/**
 * Class DroneIO
 * @package coverallskit\entity\service
 */
final class DroneIO extends AbstractService implements ServiceInterface
{

    /**
     * {@inheritdoc}
     */
    protected $name = 'drone.io';

    /**
     * {@inheritdoc}
     */
    protected $jobNumberKey = 'DRONE_BUILD_NUMBER';

}
