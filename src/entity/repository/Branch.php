<?php

namespace coverallskit\entity\repository;

use coverallskit\AttributePopulatable;
use coverallskit\Entity;

class Branch implements Entity
{
    use AttributePopulatable;

    private $name;
    private $remote;

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
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
