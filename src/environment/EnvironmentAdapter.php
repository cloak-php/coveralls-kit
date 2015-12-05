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
 * Interface EnvironmentAdapter
 */
interface EnvironmentAdapter
{
    const CI = 'CI';
    const COVERALLS_REPO_TOKEN = 'COVERALLS_REPO_TOKEN';

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getBuildJobId();

    /**
     * @return string
     */
    public function getCoverallsToken();

    /**
     * @return bool
     */
    public function isSupported();
}
