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

class SourceFileCollection implements CompositeEntityInterface
{

    protected $sources = null; 

    public function __construct()
    {
        $this->sources = new Sequence();
    }

    public function add(SourceFile $source)
    {
        $this->sources->add($source);
    }

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

    public function isEmpty()
    {
        return $this->sources->isEmpty();
    }

    public function toArray()
    {
        $values = [];
        $sources = $this->sources->getIterator();

        foreach ($sources as $source) {
            $values[] = $source->toArray();
        }

        return $values;
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }

}
