<?php

namespace coverallskit\entity\collection;

use coverallskit\AttributePopulatable;
use coverallskit\entity\repository\Remote;
use PhpCollection\Sequence;

/**
 * Class RemoteCollection
 */
class RemoteCollection implements CompositeEntityCollection
{
    use AttributePopulatable;

    protected $remotes;

    /**
     * @param array $remotes
     */
    public function __construct(array $remotes = [])
    {
        $this->remotes = new Sequence($remotes);
    }

    /**
     * @param Remote $remote
     */
    public function add(Remote $remote)
    {
        return $this->remotes->add($remote);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->remotes->isEmpty();
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return $this->remotes->getIterator();
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->remotes->count();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $arrayValues = [];
        $remotes = $this->remotes->getIterator();

        foreach ($remotes as $remote) {
            $arrayValues[] = $remote->toArray();
        }

        return $arrayValues;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->toArray());
    }
}
