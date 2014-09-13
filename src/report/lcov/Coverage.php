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
 * Class Coverage
 * @package coverallskit\report\lcov
 */
class Coverage extends Line
{

    const PATTURN = '/^DA:(\d+),(\d+)/';

    /**
     * @var int
     */
    private $lineNumber;

    /**
     * @var int
     */
    private $executeCount;


    protected function parse()
    {
        $matches = [];
        preg_match(self::PATTURN, $this->record, $matches);
        array_shift($matches);
        list($lineNumber, $executeCount) = $matches;

        $this->lineNumber = (int) $lineNumber;
        $this->executeCount = (int) $executeCount;
    }

    /**
     * @return int
     */
    public function getLineNumber()
    {
        return $this->lineNumber;
    }

    /**
     * @return int
     */
    public function getExecuteCount()
    {
        return $this->executeCount;
    }

    /**
     * @param string $record
     * @return bool
     */
    public static function match($record)
    {
        return preg_match(self::PATTURN, $record) === 1;
    }

}
