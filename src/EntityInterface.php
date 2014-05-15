<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit;

interface EntityInterface
{

    /**
     * @param array
     */
    public function populate(array $values);

    /**
     * @return boolean
     */
    public function isEmpty();  

    /**
     * @return string
     */
    public function __toString();  

}
