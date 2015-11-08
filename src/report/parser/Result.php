<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace coverallskit\report\parser;

use coverallskit\entity\collection\SourceFileCollection;
use coverallskit\exception\ExceptionCollection;

/**
 * Class Result
 */
class Result
{
    /**
     * @var \coverallskit\entity\collection\SourceFileCollection
     */
    private $sources;

    /**
     * @var \coverallskit\exception\ExceptionCollection
     */
    private $parseErrors;

    /**
     * @param SourceFileCollection $sources
     */
    public function __construct(SourceFileCollection $sources, ExceptionCollection $parseErrors)
    {
        $this->sources = $sources;
        $this->parseErrors = $parseErrors;
    }

    /**
     * @return SourceFileCollection
     */
    public function getSources()
    {
        return $this->sources;
    }

    /**
     * @return int
     */
    public function getExecutedLineCount()
    {
        return $this->sources->getExecutedLineCount();
    }

    /**
     * @return int
     */
    public function getUnusedLineCount()
    {
        return $this->sources->getUnusedLineCount();
    }

    /**
     * @return ExceptionCollection
     */
    public function getParseErrors()
    {
        return $this->parseErrors;
    }

    /**
     * @return bool
     */
    public function hasParseError()
    {
        return $this->parseErrors->isEmpty() === false;
    }
}
