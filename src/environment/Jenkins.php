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
 * Class Jenkins
 */
final class Jenkins extends AbstractAdaptor implements EnvironmentAdaptor
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jenkins';
    }

    /**
     * {@inheritdoc}
     */
    public function getBuildJobId()
    {
        return $this->environment->get('BUILD_NUMBER');
    }

    /**
     * {@inheritdoc}
     */
    public function isSupported()
    {
        $value = $this->environment->get('JENKINS_URL');

        return $value !== null;
    }
}
