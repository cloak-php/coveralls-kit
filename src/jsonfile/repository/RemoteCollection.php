<?php

namespace coveralls\jsonfile\repository;

use PhpCollection\Sequence;
use coveralls\ArrayConvertible;

class RemoteCollection implements ArrayConvertible
{

    protected $remotes = null;

    public function __construct(array $remotes = [])
    {
        $this->remotes = new Sequence($remotes);
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
