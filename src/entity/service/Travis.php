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
 * Class Travis
 * @package coverallskit\entity\service
 */
abstract class Travis extends AbstractService implements ServiceInterface
{

    /**
     * {@inheritdoc}
     */
    protected $jobNumberKey = 'TRAVIS_JOB_ID';

}
