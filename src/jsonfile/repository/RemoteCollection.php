<?php

namespace coveralls\jsonfile\repository;

use PhpCollection\Sequence;

class RemoteCollection
{

    protected $remotes = null;

    public function  __construct(array $remotes)
    {
        $this->remotes = new Sequence($remotes);
    }

}
