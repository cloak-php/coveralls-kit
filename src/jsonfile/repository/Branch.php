<?php

namespace coveralls\jsonfile\repository;

use Gitonomy\Git\Reference\Branch as CurrentBranch;

class Branch
{

    protected $branch = null;

    public function __construct(CurrentBranch $branch)
    {
        $this->branch = $branch;
    }

    public function __toString()
    {
        return $this->branch->getName();
    }

}
