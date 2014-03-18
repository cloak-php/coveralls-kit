<?php

namespace coveralls;

class JSONFile implements JSONFileInterface
{

    protected $repositoryToken = null;

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

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        $getter = 'get' . ucwords($name);

        if (method_exists($this, $getter) === false) {
            return null;
        }

        return $this->$getter();
    }

}
