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

    public function toArray()
    {
        $results = array_pad([], $this->lineCount, null);
        $coverages = $this->lineCoverages->getIterator();

        foreach ($coverages as $coverage) {
            $results[$coverage->getLineNumber() - 1] = $coverage->valueOf();
        }

        return $results;
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }

}
