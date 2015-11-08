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

use coverallskit\value\LineRange;
use UnexpectedValueException;

/**
 * Class CoverageResult
 */
class CoverageResult implements CoverageEntity
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
        $this->lineAt = (int) $lineAt;
        $this->analysisResult = (int) $analysisResult;
        $this->validateAnalysisResult();
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
     * @param LineRange $lineRange
     *
     * @return bool
     */
    public function contains(LineRange $lineRange)
    {
        return $lineRange->contains($this);
    }

    /**
     * @param int $lineAt
     *
     * @return CoverageResult
     */
    public static function unused($lineAt)
    {
        return new self($lineAt, static::UNUSED);
    }

    /**
     * @param int $lineAt
     *
     * @return CoverageResult
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

    /**
     * @throws \UnexpectedValueException
     */
    protected function validateAnalysisResult()
    {
        $resultTypes = [static::UNUSED, static::EXECUTED];
        $result = $this->getAnalysisResult();

        if (in_array($result, $resultTypes) === true) {
            return;
        }

        $message = sprintf("Value of the analysis results is invalid.\nMust specify a 0 or 1 (got: %d)", $result);
        throw new UnexpectedValueException($message);
    }
}
