<?php

namespace coveralls\entity\repository;

use Gitonomy\Git\Reference\Branch as CurrentBranch;

class Branch
{

    protected $branch = null;

    public function __construct(CurrentBranch $branch)
    {
        $this->branch = $branch;
    }

    public function isEmpty()
    {
        return $this->branch === null;
    }

    public function __toString()
    {
        return $this->branch->getName();
    }

}
