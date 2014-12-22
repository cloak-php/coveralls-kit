<?php

use \Robo\Tasks;
use coverallskit\Configuration;
use coverallskit\ReportBuilder;


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

    public function coverallsTravisCI()
    {
        $configuration = Configuration::loadFromFile('.coveralls.yml');
        $builder = ReportBuilder::fromConfiguration($configuration);
        $builder->build()->save()->upload();
    }

    public function coverallsDroneIO()
    {
        $configuration = Configuration::loadFromFile('.drone.io.coveralls.yml');
        $builder = ReportBuilder::fromConfiguration($configuration);
        $builder->build()->save()->upload();
    }

    public function coverallsCircleCI()
    {
        $configuration = Configuration::loadFromFile('.circle-ci.coveralls.yml');
        $builder = ReportBuilder::fromConfiguration($configuration);
        $builder->build()->save()->upload();
    }

    public function exampleBasic()
    {
        $runtime = 'php';
        $enviromentValue = 'TRAVIS_JOB_ID=10';
        $exampleScript = __DIR__ . '/example/basic_example.php';

        $command = sprintf('%s %s %s', $enviromentValue, $runtime, $exampleScript);

        return $this->taskExec($command)->run();
    }

    public function exampleHhvm()
    {
        if (defined('HHVM_VERSION') === false) {
            throw new RuntimeException('Please install the hhvm');
        }

        $runtime = 'php';
        $enviromentValue = 'TRAVIS_JOB_ID=10';
        $exampleScript = __DIR__ . '/example/hhvm_example.php';

        $command = sprintf('%s %s %s', $enviromentValue, $runtime, $exampleScript);

        return $this->taskExec($command)->run();
    }

}
