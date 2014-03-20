<?php

namespace coveralls\jsonfile;

interface CoverageInterface
{

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

}
