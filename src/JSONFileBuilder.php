<?php

namespace coveralls;

use coveralls\JSONFile;
use coveralls\jsonfile\SourceFile;
use coveralls\jsonfile\SourceFileCollection;

class JSONFileBuilder
{

    protected $token = null;
    protected $sourceFiles = null;

    public function __construct()
    {
        $this->sourceFiles = new SourceFileCollection();
    }

    public function token($repositoryToken)
    {
        $this->token = $repositoryToken;
        return $this;
    }

    public function addSource(SourceFile $source)
    {
        $this->sourceFiles->add($source);
        return $this;
    }

    public function build()
    {
        return new JSONFile([
            'token' => $this->token,
            'sourceFiles' => $this->sourceFiles
        ]);
    }

}
