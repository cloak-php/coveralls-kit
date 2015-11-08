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
 * Class CodeShip
 */
final class CodeShip extends AbstractAdaptor implements EnvironmentAdaptor
{
    const NAME = 'codeship';
    const CI_NAME = 'CI_NAME';
    const CI_BUILD_NUMBER = 'CI_BUILD_NUMBER';

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
        return $this->environment->get(self::CI_BUILD_NUMBER);
    }

    /**
     * {@inheritdoc}
     */
    public function isSupported()
    {
        $value = $this->environment->get(self::CI_NAME);

        return $value === self::NAME;
    }
}
