<?php

namespace coveralls\jsonfile\repository;

use coveralls\ArrayConvertible;
use Gitonomy\Git\Commit as HeadCommit;

class Commit implements ArrayConvertible
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
