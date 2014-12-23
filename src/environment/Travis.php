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

use coverallskit\Environment;


/**
 * Class Travis
 * @package coverallskit\environment
 */
final class Travis extends AbstractAdaptor implements AdaptorInterface
{

    const NAME = 'travis-ci';
    const TRAVIS = 'TRAVIS';
    const TRAVIS_JOB_ID = 'TRAVIS_JOB_ID';


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
        return $this->environment->get(self::TRAVIS_JOB_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function isSupported()
    {
        $value = $this->environment->get(self::TRAVIS);
        return $value === 'true';
    }

}
