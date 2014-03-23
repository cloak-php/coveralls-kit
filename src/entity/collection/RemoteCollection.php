<?php

namespace coveralls\entity\collection;

use coveralls\ArrayConvertible;
use coveralls\entity\repository\Remote;
use PhpCollection\Sequence;

class RemoteCollection implements ArrayConvertible
{

    protected $remotes = null;

    public function __construct(array $remotes = [])
    {
        $this->remotes = new Sequence($remotes);
    }

    public function add(Remote $remote)
    {
        return $this->remotes->add($remote);
    }

    public function isEmpty()
    {
        return $this->remotes->isEmpty();
    }

    public function toArray()
    {
        $arrayValues = [];
        $remotes = $this->remotes->getIterator();

        foreach ($remotes as $remote) {
            $arrayValues[] = $remote->toArray();
        }

        return $arrayValues;
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }

}
