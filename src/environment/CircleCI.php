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
 * Class CircleCI
 */
final class CircleCI extends AbstractAdapter implements EnvironmentAdapter
{
    const NAME = 'circle-ci';
    const CIRCLECI = 'CIRCLECI';
    const CIRCLE_BUILD_NUM = 'CIRCLE_BUILD_NUM';

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
        return $this->environment->get(self::CIRCLE_BUILD_NUM);
    }

    /**
     * {@inheritdoc}
     */
    public function isSupported()
    {
        $value = $this->environment->get(self::CIRCLECI);

        return $value === 'true';
    }
}
