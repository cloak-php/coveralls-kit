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
use coverallskit\AttributePopulatable;
use coverallskit\exception\LineOutOfRangeException;
use PhpCollection\Map;
use coverallskit\exception\ExceptionCollection;
use IteratorAggregate;

/**
 * Class CoverageCollection
 * @package coverallskit\entity\collection
 */
class CoverageCollection implements CompositeEntityInterface, IteratorAggregate
{

    use AttributePopulatable;

    /**
     * @var \coverallskit\value\LineRange
     */
    protected $lineRange;

    /**
     * @var \PhpCollection\Map
     */
    protected $lineCoverages;

    /**
     * @param integer $lineCount
     */
    public function __construct($lineCount)
    {
        $this->lineRange = new LineRange(1, $lineCount);
        $this->lineCoverages = new Map();
    }

    /**
     * @param CoverageInterface $coverage
     * @throws \coverallskit\exception\LineOutOfRangeException
     */
    public function add(CoverageInterface $coverage)
    {
        if ($this->lineRange->contains($coverage->getLineNumber()) === false) {
            throw new LineOutOfRangeException($coverage, $this->lineRange);
        }
        $this->lineCoverages->set($coverage->getLineNumber(), $coverage);
    }

    /**
     * @param array $coverages
     * @throws \coverallskit\exception\ExceptionCollection
     */
    public function addAll(array $coverages)
    {
        $exceptions = new ExceptionCollection();

        foreach ($coverages as $coverage) {
            try {
                $this->add($coverage);
            } catch (LineOutOfRangeException $exception) {
                $exceptions->add($exception);
            }
        }

        if ($exceptions->count() <= 0) {
            return;
        }

        throw $exceptions;
    }

    /**
     * @param CoverageInterface $coverage
     */
    public function remove(CoverageInterface $coverage)
    {
        $this->removeAt($coverage->getLineNumber());
    }

    /**
     * @param $lineNumber
     */
    public function removeAt($lineNumber)
    {
        $this->lineCoverages->remove($lineNumber);
    }

    /**
     * @param $lineAt
     * @return null|void
     */
    public function at($lineAt)
    {
        $coverage = $this->lineCoverages->get($lineAt);

        if ($coverage->isEmpty()) {
            return null;
        }

        return $coverage->get();
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->lineCoverages->isEmpty();
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return $this->lineCoverages->getIterator();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $results = array_pad([], $this->lineRange->getLastLineNumber(), null);
        $coverages = $this->lineCoverages->getIterator();

        foreach ($coverages as $coverage) {
            $results[$coverage->getLineNumber() - 1] = $coverage->valueOf();
        }

        return $results;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->toArray());
    }

}
