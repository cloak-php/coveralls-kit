<?php

namespace coveralls\jsonfile;

class SourceFile
{

    protected $name = null;
    protected $content = null;
    protected $coverages = null;

    public function __construct($name)
    {
        $this->name = realpath($name);
        $this->content = file_get_contents($this->name);
        $count = split(PHP_EOL, $this->content);
        $this->coverages = new CoverageCollection($count);
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

    public function getCoverages()
    {
        return $this->coverages;
    }

}
