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
* Class CircleCI
* @package coverallskit\entity\service
*/
final class CircleCI extends AbstractService implements ServiceInterface
{

    /**
     * {@inheritdoc}
     */
    protected $name = 'circle-ci';

    /**
     * {@inheritdoc}
     */
    protected $jobNumberKey = 'CIRCLE_BUILD_NUM';

}
