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
 * Class Travis
 */
abstract class Travis extends AbstractAdapter implements EnvironmentAdapter
{
    const TRAVIS = 'TRAVIS';
    const TRAVIS_JOB_ID = 'TRAVIS_JOB_ID';

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
