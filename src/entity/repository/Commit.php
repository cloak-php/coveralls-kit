<?php

namespace coverallskit\entity\repository;

use coverallskit\CompositeEntity;
use coverallskit\AttributePopulatable;


/**
 * Class Commit
 * @package coverallskit\entity\repository
 */
class Commit implements CompositeEntity
{

    use AttributePopulatable;

    private $id;
    private $authorName;
    private $authorEmail;
    private $committerName;
    private $committerEmail;
    private $message;


    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->populate($values);
    }

    public function isEmpty()
    {
        return $this->getHash() === null;
    }

    public function getHash()
    {
        return $this->id;
    }

    public function getAuthorName()
    {
        return $this->authorName;
    }

    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    public function getCommitterName()
    {
        return $this->committerName;
    }

    public function getCommitterEmail()
    {
        return $this->committerEmail;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function toArray()
    {
        return [
            'id' => $this->getHash(),
            'author_name' => $this->getAuthorName(),
            'author_email' => $this->getAuthorEmail(),
            'committer_name' => $this->getCommitterName(),
            'committer_email' => $this->getCommitterEmail(),
            'message' => $this->getMessage()
        ];
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }

}
