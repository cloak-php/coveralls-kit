<?php

namespace coveralls\jsonfile;

class Coverage
{

    const UNUSED = 0;
    const EXECUTED = 1;

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

    public static function unused($lineAt)
    {
        return new static($lineAt, static::UNUSED);
    }

    public static function executed($lineAt)
    {
        return new static($lineAt, static::EXECUTED);
    }

}
