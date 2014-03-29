<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\entity\collection;

use coverallskit\CompositeEntityInterface;
use coverallskit\entity\CoverageInterface;
use coverallskit\value\LineRange;
use PhpCollection\Map;

class CoverageCollection implements CompositeEntityInterface
{

    protected $lineRange = null;
    protected $lineCoverages = null;

    /**
     * @param integer $lineCount
     */
    public function __construct($lineCount)
    {
        $this->lineRange = new LineRange(1, $lineCount);
        $this->lineCoverages = new Map();
    }

    public function add(CoverageInterface $coverage)
    {
        if ($this->lineRange->contains($coverage->getLineNumber()) === false) {
            return;
        }
        $this->lineCoverages->set($coverage->getLineNumber(), $coverage);
    }

    public function remove(CoverageInterface $coverage)
    {
        $this->removeAt($coverage->getLineNumber());
    }

    public function removeAt($lineNumber)
    {
        $this->lineCoverages->remove($lineNumber);
    }

    public function at($lineAt)
    {
        $coverage = $this->lineCoverages->get($lineAt);

        if ($coverage->isEmpty()) {
            return null;
        }

        return $coverage->get();
    }

    public function isEmpty()
    {
        return $this->lineCoverages->isEmpty();
    }

    public function toArray()
    {
        $results = array_pad([], $this->lineRange->getLastLineNumber(), null);
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
