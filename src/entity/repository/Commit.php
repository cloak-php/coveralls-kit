<?php

namespace coverallskit\entity\repository;

use coverallskit\CompositeEntityInterface;
use coverallskit\AttributePopulatable;

class Commit implements CompositeEntityInterface
{

    use AttributePopulatable;

    protected $id = null;
    protected $authorName = null;
    protected $authorEmail = null;
    protected $committerName = null;
    protected $committerEmail = null;
    protected $message = null;

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
