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

use coverallskit\CompositeEntityInterface;

interface ServiceInterface extends CompositeEntityInterface
{

    const ENV_COVERALLS_REPO_TOKEN_KEY = 'COVERALLS_REPO_TOKEN';

    /**
     * @return string
     */
    public function getServiceJobId();

    /**
     * @return string
     */
    public function getServiceName();

    /**
     * @return string|null
     */
    public function getCoverallsToken();

}

