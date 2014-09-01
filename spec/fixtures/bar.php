<?php

namespace coverallskit;

class Bar
{

    private $name;
    private $description;

    public function __construct()
    {
        $this->name = 'bar';
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->$description;
    }

}
