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

use coverallskit\exception\BadAttributeException;

trait AttributePopulatable
{
    public function populate(array $values)
    {
        foreach ($values as $key => $value) {
            $setter = 'set' . ucfirst($key);

            if (method_exists($this, $setter) === true) {
                $this->$setter($value);
            } elseif (property_exists($this, $key) === true) {
                $this->$key = $value;
            } else {
                throw new BadAttributeException($key);
            }
        }
    }
}
