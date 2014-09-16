<?php

namespace coverallskit;

class Foo
{

    private $name;

    public function __construct()
    {
        $this->name = 'foo';
    }

    public function getName()
    {
        return $this->name;
    }

}
