<?php

namespace coveralls\jsonfile;

use PhpCollection\Map;

class CoverageCollection
{

    protected $lineCount = null;
    protected $lineCoverages = null;

    public function __construct($lineCount)
    {
        $this->lineCount = $lineCount;
        $this->lineCoverages = new Map();
    }

    public function add(CoverageInterface $coverage)
    {
        $this->lineCoverages->set($coverage->getLineNumber(), $coverage);
    }

    public function at($lineAt)
    {
        $coverage = $this->lineCoverages->get($lineAt);

        if ($coverage->isEmpty()) {
            return null;
        }

        return $coverage->get();
    }

    public function toJSON()
    {
        $results = array_pad(array(), $this->lineCount, null);
        $coverages = $this->lineCoverages->getIterator();

        foreach ($coverages as $coverage) {
            $results[$coverage->getLineNumber() - 1] = $coverage->valueOf();
        }

        return json_encode($results);
    }

}
