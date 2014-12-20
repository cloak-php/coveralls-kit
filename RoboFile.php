<?php

use \Robo\Tasks;

/**
 * Class RoboFile
 */
class RoboFile extends Tasks
{

    public function specAll()
    {
        $peridot = 'vendor/bin/peridot';
        $peridotSpecTargets = '--grep "spec/*Spec.php"';

        return $this->taskExec($peridot . ' ' . $peridotSpecTargets)->run();
    }

}
