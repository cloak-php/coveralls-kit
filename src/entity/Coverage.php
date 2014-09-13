<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\entity;

/**
 * Class Coverage
 * @package coverallskit\entity
 */
class Coverage implements CoverageInterface 
{

    /**
     * @var int
     */
    private $lineAt;

    /**
     * @var int
     */
    private $analysisResult;


    /**
     * @param int $lineAt
     * @param int $analysisResult
     */
    public function __construct($lineAt, $analysisResult)
    {
        $this->lineAt = $lineAt;
        $this->analysisResult = $analysisResult;
    }

    /**
     * @return int
     */
    public function getLineNumber()
    {
        return $this->lineAt;
    }

    /**
     * @return int
     */
    public function getAnalysisResult()
    {
        return $this->analysisResult;
    }

    /**
     * @return bool
     */
    public function isUnused()
    {
        return $this->getAnalysisResult() === static::UNUSED;
    }

    /**
     * @return bool
     */
    public function isExecuted()
    {
        return $this->getAnalysisResult() === static::EXECUTED;
    }

    /**
     * @param int $lineCount
     * @return bool
     */
    public function isValidLine($lineCount)
    {
        return $this->getLineNumber() >= 1 && $this->getLineNumber() <= $lineCount;
    }

    /**
     * @param int $lineAt
     * @return Coverage
     */
    public static function unused($lineAt)
    {
        return new self($lineAt, static::UNUSED);
    }

    /**
     * @param int $lineAt
     * @return Coverage
     */
    public static function executed($lineAt)
    {
        return new self($lineAt, static::EXECUTED);
    }

    /**
     * @return int
     */
    public function valueOf()
    {
        return $this->getAnalysisResult();
    }

}
