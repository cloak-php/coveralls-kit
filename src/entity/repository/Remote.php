<?php

namespace coverallskit\entity\repository;

use coverallskit\CompositeEntityInterface;
use coverallskit\AttributePopulatable;


/**
 * Class Remote
 * @package coverallskit\entity\repository
 */
class Remote implements CompositeEntityInterface
{

    use AttributePopulatable;

    private $name;
    private $url;


    /**
     * @param array $values
     */
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
