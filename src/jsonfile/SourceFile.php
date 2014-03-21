<?php

namespace coveralls\jsonfile;

use UnexpectedValueException;

class SourceFile
{

    protected $name = null;
    protected $content = null;
    protected $coverages = null;

    public function __construct($name)
    {
        $this->resolvePath($name);
        $this->resolveContent();
    }

    protected function resolvePath($name)
    {
        $path = realpath($name);

        if (file_exists($path) === false) {
            throw new UnexpectedValueException("Can not find the source file $path");
        }

        $this->name = $path;
    }

    protected function resolveContent()
    {
        $content = file_get_contents($this->getName());
        $this->content = $content;
        $this->coverages = new CoverageCollection(split(PHP_EOL, $content));
    }

    public function getName()
    {
        return $this->name;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getCoverages()
    {
        return $this->coverages;
    }

}
