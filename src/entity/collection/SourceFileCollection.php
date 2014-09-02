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
use coverallskit\entity\SourceFile;
use PhpCollection\Sequence;
use coverallskit\AttributePopulatable;
use IteratorAggregate;
use ArrayIterator;


/**
 * Class SourceFileCollection
 * @package coverallskit\entity\collection
 */
class SourceFileCollection implements CompositeEntityInterface, IteratorAggregate
{

    use AttributePopulatable;

    /**
     * @var \PhpCollection\Sequence
     */
    protected $sources;

    public function __construct()
    {
        $this->sources = new Sequence();
    }

    /**
     * @param SourceFile $source
     */
    public function add(SourceFile $source)
    {
        $this->sources->add($source);
    }

    /**
     * @param $source
     * @return bool
     */
    public function has($source)
    {
        $querySource = $source;

        if (gettype($source) === 'string') {
            $querySource = new SourceFile($source);
        }

        $applyFilter = function(SourceFile $element) use ($querySource) {
            return $element->getName() === $querySource->getName();
        };

        $results = $this->sources->filter($applyFilter);

        return $results->isEmpty() === false;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->sources->isEmpty();
    }

    /**
     * @return ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return $this->sources->getIterator();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $values = [];
        $sources = $this->sources->getIterator();

        foreach ($sources as $source) {
            $values[] = $source->toArray();
        }

        return $values;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->toArray());
    }

}
