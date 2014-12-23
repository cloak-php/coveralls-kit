<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\entity;


use coverallskit\CompositeEntityInterface;


/**
 * Interface ServiceInterface
 * @package coverallskit\entity\service
 */
interface ServiceInterface extends CompositeEntityInterface
{

    /**
     * @return string
     */
    public function getServiceName();

    /**
     * @return string
     */
    public function getServiceJobId();

    /**
     * @return string|null
     */
    public function getCoverallsToken();

}
