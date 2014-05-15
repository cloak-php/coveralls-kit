<?php

namespace coverallskit\entity\repository;

use coverallskit\CompositeEntityInterface;
use coverallskit\AttributePopulatable;

class Remote implements CompositeEntityInterface
{

    use AttributePopulatable;

    protected $name = null;
    protected $url = null;

    public function __construct(array $values = [])
    {
        $this->populate($values);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getURL()
    {
        return $this->url;
    }

    public function isEmpty()
    {
        return ($this->getName() === null) || ($this->getURL() === null);
    }

    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'url' => $this->getURL()
        ];
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }

}
