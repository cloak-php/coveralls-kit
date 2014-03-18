<?php

namespace coveralls\jsonfile;

class SourceFile
{

    protected $name = null;
    protected $content = null;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getContent()
    {
        if ($this->content === null) {
            $this->content = file_get_contents($this->getName());
        }

        return $this->content;
    }

}
