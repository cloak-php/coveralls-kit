<?php

namespace coveralls\jsonfile;

use coveralls\exception\FileNotFoundException;

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
            throw new FileNotFoundException("Can not find the source file $path");
        }

        $this->name = $path;
    }

    protected function resolveContent()
    {
        $content = file_get_contents($this->getName());
        $lineCount = count(split(PHP_EOL, $content));
        $this->content = $content;
        $this->coverages = new CoverageCollection($lineCount);
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

    public function toArray()
    {
        $values = array(
            'name' => $this->getName(),
            'content' => $this->getContent(),
            'coverage' => $this->getCoverages()->toArray(),
        );

        return $values;
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }

}
