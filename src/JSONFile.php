<?php

namespace coveralls;

use coveralls\jsonfile\SourceFileCollection;

class JSONFile implements JSONFileInterface
{

    protected $token = null;
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
            'source_files' => $this->sourceFiles->toArray(),
            'run_at' => $this->runAt
        );

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
