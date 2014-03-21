<?php

namespace coveralls\jsonfile;

interface CoverageInterface
{

    const UNUSED = 0;
    const EXECUTED = 1;

    /**
     * @return integer
     */
    public function getLineNumber();

    /**
     * @return boolean
     */
    public function isUnused();

    /**
     * @return boolean
     */
    public function isExecuted();

    /**
     * @return mixed
     */
    public function valueOf(); 

}
