<?php

namespace coveralls;

class JSONFile implements JSONFileInterface
{

    protected $repositoryToken = null;
    protected $sourceFiles = null;

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        foreach ($values as $key => $value) {
            $this->$key = $value;
        }
    }

    public function getRepositoryToken()
    {
        return $this->repositoryToken;
    }

    public function getSourceFiles()
    {
        return $this->sourceFiles;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        $getter = 'get' . ucwords($name);


        //FIXME throw exception
        if (method_exists($this, $getter) === false) {
            return null;
        }

        return $this->$getter();
    }

}
