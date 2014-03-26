<?php

namespace coverallskit\entity\repository;

use coverallskit\EntityInterface;

class Branch implements EntityInterface
{

    protected $name = null;
    protected $remote = null;

    public function __construct(array $values)
    {
        foreach ($values as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return boolean 
     */
    public function isRemote()
    {
        return $this->remote;
    }

    /**
     * @return boolean 
     */
    public function isEmpty()
    {
        return $this->name === null;
    }

    /**
     * @return string 
     */
    public function __toString()
    {
        return $this->getName();
    }

}
