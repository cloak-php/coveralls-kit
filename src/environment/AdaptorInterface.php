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
 * Interface AdaptorInterface
 * @package coverallskit\environment
 */
interface AdaptorInterface
{

    const CI = 'CI';

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getBuildJobId();

    /**
     * @return bool
     */
    public function isSupported();

}
