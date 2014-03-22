<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coveralls\jsonfile;

class Coverage implements CoverageInterface 
{

    protected $lineAt = null;
    protected $analysisResult = null;

    public function __construct($lineAt, $analysisResult)
    {
        $this->lineAt = $lineAt;
        $this->analysisResult = $analysisResult;
    }

    public function getLineNumber()
    {
        return $this->lineAt;
    }

    public function getAnalysisResult()
    {
        return $this->analysisResult;
    }

    public function isUnused()
    {
        return $this->getAnalysisResult() === static::UNUSED;
    }

    public function isExecuted()
    {
        return $this->getAnalysisResult() === static::EXECUTED;
    }

    public static function unused($lineAt)
    {
        return new static($lineAt, static::UNUSED);
    }

    public static function executed($lineAt)
    {
        return new static($lineAt, static::EXECUTED);
    }

    public function valueOf()
    {
        $value = null;

        if ($this->isExecuted()) {
            $value = static::EXECUTED;
        } else if ($this->isUnused()) {
            $value = static::UNUSED;
        }

        return $value;
    }

}
