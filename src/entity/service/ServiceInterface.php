<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coveralls\entity\service;

use coveralls\CompositeEntityInterface;

interface ServiceInterface extends CompositeEntityInterface
{

    public function getJobId();

    public function getServiceName();

}
