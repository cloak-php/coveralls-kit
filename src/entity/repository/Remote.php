<?php

namespace coverallskit\entity\repository;

use coverallskit\CompositeEntityInterface;

class Remote implements CompositeEntityInterface
{

    protected $name = null;
    protected $url = null;

    public function __construct($name = null, $url = null)
    {
        $this->setName($name);
        $this->setURL($url);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getURL()
    {
        return $this->url;
    }

    public function setURL($url)
    {
        $this->url = $url;
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
