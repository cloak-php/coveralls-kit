<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\report\lcov;

/**
 * Interface FileRecord
 * @package coverallskit\report\lcov
 */
interface FileRecord
{

    /**
     * @param string $record
     * @return bool
     */
    public static function match($record);

}
