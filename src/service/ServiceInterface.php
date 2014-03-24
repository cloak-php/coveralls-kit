<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coveralls\service;

use coveralls\ArrayConvertible;

interface ServiceInterface extends ArrayConvertible
{

    public function getJobId();

    public function getServiceName();

}
