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
 * Class SourceFile
 * @package coverallskit\report\lcov
 */
class SourceFile extends Record
{

    const PATTURN = '/^SF:(.+)$/';

    /**
     * @var string
     */
    private $fileName;

    protected function parse()
    {
        $this->fileName = preg_replace(self::PATTURN, '$1', $this->record);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->fileName;
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
