<?php

namespace coveralls;

use PhpCollection\SequenceInterface;

interface JSONFileInterface
{

    /**
     * @return string  
     */
    public function getRepositoryToken();

    /**
     * @return SequenceInterface  
     */
    public function getSourceFiles();

}
