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

use coverallskit\CompositeEntity;
use coverallskit\entity\collection\CoverageCollection;
use coverallskit\exception\FileNotFoundException;
use coverallskit\AttributePopulatable;
use coverallskit\exception\LineOutOfRangeException;
use coverallskit\value\LineRange;

/**
 * Class SourceFile
 * @package coverallskit\entity
 */
class SourceFile implements CompositeEntity
{

    use AttributePopulatable;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var \coverallskit\entity\collection\CoverageCollection
     */
    protected $coverages;

    /**
     * @var \coverallskit\value\LineRange
     */
    protected $realLineRange;


    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->resolvePath($name);
        $this->resolveContent();
    }

    /**
     * @param string $name
     * @throws \coverallskit\exception\FileNotFoundException
     */
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

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPathFromCurrentDirectory()
    {
        return str_replace(getcwd() . '/', '', $this->getName());
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return CoverageCollection
     */
    public function getCoverages()
    {
        return $this->coverages;
    }

    /**
     * @return CoverageCollection
     */
    public function getEmptyCoverages()
    {
        return $this->coverages->newInstance();
    }

    /**
     * @param CoverageInterface $coverage
     * @throws \coverallskit\exception\LineOutOfRangeException
     * @throws \Exception
     */
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

    /**
     * @param CoverageCollection $coverages
     */
    public function addCoverages(CoverageCollection $coverages)
    {
        $this->coverages->merge($coverages);
    }

    /**
     * @param $coverage
     */
    public function removeCoverage($coverage)
    {
        $lineNumber = $coverage;

        if ($coverage instanceof CoverageInterface) {
            $lineNumber = $coverage->getLineNumber();
        }

        $this->coverages->removeAt($lineNumber);
    }

    /**
     * @param $lineNumber
     * @return null|void
     */
    public function getCoverage($lineNumber)
    {
        return $this->coverages->at($lineNumber);
    }

    /**
     * @return int
     */
    public function getExecutedLineCount()
    {
        return $this->coverages->getExecutedLineCount();
    }

    /**
     * @return int
     */
    public function getUnusedLineCount()
    {
        return $this->coverages->getUnusedLineCount();
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        $content = $this->getContent();
        return empty($content);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $values = [
            'name' => $this->getPathFromCurrentDirectory(),
            'source' => $this->getContent(),
            'coverage' => $this->getCoverages()->toArray(),
        ];

        return $values;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->toArray());
    }

}
