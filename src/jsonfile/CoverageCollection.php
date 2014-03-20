<?php

namespace coveralls\jsonfile;

use PhpCollection\Map;

class CoverageCollection
{

    protected $coverages = null;

    public function __construct()
    {
        $this->coverages = new Map();
    }

    public function add(Coverage $coverage)
    {
        $this->coverages->set($coverage->getLineNumber(), $coverage);
    }

    public function at($lineAt)
    {
        return $this->coverages->get($lineAt)->get();
    }

}
