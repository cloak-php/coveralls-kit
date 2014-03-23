<?php

namespace coveralls\entity\repository;

use coveralls\CompositeEntityInterface;

class Remote implements CompositeEntityInterface
{

    protected $name = null;
    protected $url = null;

    public function __construct($name, $url)
    {
        $this->name = $name;
        $this->url = $url;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'url' => $this->url
        ];
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }

}
