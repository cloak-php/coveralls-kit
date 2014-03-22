<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coveralls;

use coveralls\jsonfile\SourceFileCollection;

class JSONFile implements JSONFileInterface
{

    protected $token = null;
    protected $service = null;
    protected $repository = null;
    protected $sourceFiles = null;
    protected $runAt = null;

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        foreach ($values as $key => $value) {
            $this->$key = $value;
        }
    }

    public function saveAs($path)
    {
        $content = (string) $this;
        file_put_contents($path, $content);
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
