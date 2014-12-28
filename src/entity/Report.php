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

use coverallskit\AttributePopulatable;
use coverallskit\ReportTransferAwareTrait;

/**
 * Class Report
 * @package coverallskit\entity
 */
class Report implements ReportInterface
{

    use AttributePopulatable;
    use ReportTransferAwareTrait;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $token;

    /**
     * @var \coverallskit\entity\ServiceInterface
     */
    private $service;

    /**
     * @var \coverallskit\entity\RepositoryInterface
     */
    private $repository;

    /**
     * @var \coverallskit\entity\collection\SourceFileCollection
     */
    private $sourceFiles;

    /**
     * @var string
     */
    private $runAt;


    /**
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->name = getcwd() . '/' . static::DEFAULT_NAME;
        $this->populate($values);
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
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return ServiceInterface
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @return RepositoryInterface
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @return collection\SourceFileCollection
     */
    public function getSourceFiles()
    {
        return $this->sourceFiles;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function saveAs($path)
    {
        $this->name = $path;
        $this->save();

        return $this;
    }

    /**
     * @return $this
     */
    public function save()
    {
        $content = (string) $this;
        file_put_contents($this->name, $content);
        return $this;
    }

    public function upload()
    {
        $fileName = $this->getName();

        if (file_exists($fileName) === false) {
            $this->saveAs($fileName);
        }

        $this->getReportTransfer()->upload($this);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->token === null || $this->service->isEmpty() || $this->sourceFiles->isEmpty();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $values = [
            'repo_token' => $this->token,
            'git' => $this->repository->toArray(),
            'source_files' => $this->sourceFiles->toArray(),
            'run_at' => $this->runAt
        ];

        $serviceValues = $this->service->toArray();
        foreach ($serviceValues as $key => $value) {
            $values[$key] = $value;
        }

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
