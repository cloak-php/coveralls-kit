<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\entity;

use coverallskit\CompositeEntityInterface;
use coverallskit\entity\CoverageInterface;
use coverallskit\entity\collection\CoverageCollection;
use coverallskit\exception\FileNotFoundException;
use coverallskit\AttributePopulatable;
use coverallskit\exception\LineOutOfRangeException;
use coverallskit\value\LineRange;

class SourceFile implements CompositeEntityInterface
{

    use AttributePopulatable;

    protected $name = null;
    protected $content = null;
    protected $coverages = null;
    protected $realLineRange = null; 

    /**
     * @param string $name
     */
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
        $realLineCount = count(explode(PHP_EOL, $content));

        $this->realLineRange = new LineRange(1, $realLineCount);

        $content = trim($content);
        $lineCount = count(explode(PHP_EOL, $content));

        $this->content = $content;
        $this->coverages = new CoverageCollection($lineCount);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPathFromCurrentDirectory()
    {
        return str_replace(getcwd() . '/', '', $this->getName());
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getCoverages()
    {
        return $this->coverages;
    }

    public function addCoverage(CoverageInterface $coverage)
    {
        try {
            $this->coverages->add($coverage);
        } catch (LineOutOfRangeException $exception) {
            if ($this->realLineRange->contains($coverage)) {
                return;
            }
            throw $exception;
        }
    }

    public function removeCoverage($coverage)
    {
        $lineNumber = $coverage;

        if ($coverage instanceof CoverageInterface) {
            $lineNumber = $coverage->getLineNumber();
        }

        $this->coverages->removeAt($lineNumber);
    }

    public function getCoverage($lineNumber)
    {
        return $this->coverages->at($lineNumber);
    }

    public function isEmpty()
    {
        $content = $this->getContent();
        return empty($content);
    }

    public function toArray()
    {
        $values = [
            'name' => $this->getPathFromCurrentDirectory(),
            'source' => $this->getContent(),
            'coverage' => $this->getCoverages()->toArray(),
        ];

        return $values;
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }

}
