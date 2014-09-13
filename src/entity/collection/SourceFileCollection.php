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

use coverallskit\entity\SourceFile;
use coverallskit\AttributePopulatable;
use PhpCollection\Map;


/**
 * Class SourceFileCollection
 * @package coverallskit\entity\collection
 */
class SourceFileCollection implements CompositeEntityCollectionInterface
{

    use AttributePopulatable;

    /**
     * @var \PhpCollection\Map
     */
    protected $sources;

    public function __construct()
    {
        $this->sources = new Map();
    }

    /**
     * @param SourceFile $source
     */
    public function add(SourceFile $source)
    {
        $key = $source->getName();
        $this->sources->set($key, $source);
    }

    /**
     * @param string|\coverallskit\entity\SourceFile $source
     * @return bool
     */
    public function has($source)
    {
        $path = (gettype($source) === 'string')
            ? realpath($source) : $source->getName();

        return $this->sources->containsKey($path);
    }

    /**
     * @param string $source
     * @return null|\coverallskit\entity\SourceFile
     */
    public function get($source)
    {
        $path = realpath($source);
        $path = $path ?: '';

        $result = $this->sources->get($path);

        if ($result->isEmpty()) {
            return null;
        }

        return $result->get();
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->sources->isEmpty();
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return $this->sources->getIterator();
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->sources->count();
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
