<?php

namespace coveralls\jsonfile;

use PhpCollection\Sequence;

class SourceFileCollection
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
