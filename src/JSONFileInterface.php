<?php

namespace coveralls;

interface JSONFileInterface
{

    /**
     * @return string  
     */
    public function getToken();

    /**
     * @return coveralls\jsonfile\SourceFileCollection;
     */
    public function getSourceFiles();

}
