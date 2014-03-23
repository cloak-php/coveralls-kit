<?php

namespace coveralls\entity\repository;

use coveralls\CompositeEntityInterface;
use Gitonomy\Git\Commit as HeadCommit;

class Commit implements CompositeEntityInterface
{

    protected $commit = null;

    public function __construct(HeadCommit $commit)
    {
        $this->commit = $commit;
    }

    public function isEmpty()
    {
        return $this->commit === null;
    }

    public function toArray()
    {
        return [
            'id' => $this->commit->getHash(),
            'author_name' => $this->commit->getAuthorName(),
            'author_email' => $this->commit->getAuthorEmail(),
            'committer_name' => $this->commit->getCommitterName(),
            'committer_email' => $this->commit->getCommitterEmail(),
            'message' => $this->commit->getMessage()
        ];
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }

}
