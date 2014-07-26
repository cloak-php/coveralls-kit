<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\entity\service\travis;

use coverallskit\entity\service\Travis;
use coverallskit\AttributePopulatable;

/**
 * Class TravisCI
 * @package coverallskit\entity\service
 */
class TravisCI extends Travis
{

    use AttributePopulatable;

    const NAME = 'travis-ci';

}
