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
 * Class EndOfRecord
 * @package coverallskit\report\lcov
 */
final class EndOfRecord implements RecordInterface
{

    const PATTURN = '/^end_of_record$/';

    /**
     * @param string $record
     * @return bool
     */
    public static function match($record)
    {
        return preg_match(self::PATTURN, $record) === 1;
    }

}
