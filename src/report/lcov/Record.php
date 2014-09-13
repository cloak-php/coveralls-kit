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
 * Class Record
 * @package coverallskit\report\lcov
 */
abstract class Record
{

    /**
     * @var string
     */
    protected $record;

    /**
     * @param string $record
     */
    public function __construct($record)
    {
        $this->record = $record;
        $this->parse();
    }

    abstract protected function parse();

    /**
     * @param string $record
     * @return bool
     */
    abstract public static function match($record);

}
