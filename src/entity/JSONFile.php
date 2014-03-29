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

use coverallskit\JSONFileUpLoader;
use coverallskit\JSONFileUpLoaderInterface;
use coverallskit\AttributePopulatable;

class JSONFile implements JSONFileInterface
{

    use AttributePopulatable;

    protected $name = null;
    protected $token = null;
    protected $service = null;
    protected $repository = null;
    protected $sourceFiles = null;
    protected $runAt = null;
    protected $uploader = null;

    /**
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->populate($values);
    }

    public function getName()
    {
        return $this->name;
    }

    public function saveAs($path)
    {
        $this->name = $path;

        $content = (string) $this;
        file_put_contents($path, $content);

        return $this; 
    }

    public function setUpLoader(JSONFileUpLoaderInterface $uploader)
    {
        $this->uploader = $uploader;
    }

    public function getUpLoader()
    {
        if ($this->uploader === null) {
            $this->uploader = new JSONFileUpLoader();
        }

        return $this->uploader;
    }

    public function upload()
    {
        if ($this->getName() === null) {
            $this->saveAs(getcwd() . '/' . static::DEFAULT_NAME);
        }
        $this->getUpLoader()->upload($this);
    }

    public function isEmpty()
    {
        return $this->token === null || $this->service->isEmpty() || $this->sourceFiles->isEmpty();
    }

    public function toArray()
    {
        $values = array(
            'repo_token' => $this->token,
            'git' => $this->repository->toArray(),
            'source_files' => $this->sourceFiles->toArray(),
            'run_at' => $this->runAt
        );

        $serviceValues = $this->service->toArray();
        foreach ($serviceValues as $key => $value) {
            $values[$key] = $value;
        }

        return $values;
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }

}
