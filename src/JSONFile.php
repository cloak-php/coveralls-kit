<?php

namespace coveralls;

use coveralls\jsonfile\SourceFileCollection;

class JSONFile implements JSONFileInterface
{

    protected $token = null;
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

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($repositoryToken)
    {
        $this->token = $repositoryToken;
    }

    public function getSourceFiles()
    {
        return $this->sourceFiles;
    }

    public function setSourceFiles(SourceFileCollection $sourceFiles)
    {
        $this->sourceFiles = $sourceFiles;
    }

    public function __set($name, $value)
    {
        $setter = 'set' . ucwords($name);

        //FIXME throw exception
        if (method_exists($this, $setter) === false) {
            return null;
        }

        return $this->$setter($value);
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
