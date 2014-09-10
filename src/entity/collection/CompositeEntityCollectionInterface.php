<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\entity\collection;

use coverallskit\CompositeEntityInterface;
use IteratorAggregate;

/**
 * Interface CompositeEntityCollectionInterface
 * @package coverallskit\entity\collection
 */
interface CompositeEntityCollectionInterface extends CompositeEntityInterface, IteratorAggregate
{
}
