<?php

use \Robo\Tasks;
use coverallskit\BuilderConfiguration;
use coverallskit\CoverallsReportBuilder;
use peridot\robo\loadTasks as PeridotTasks;


/**
 * Class RoboFile
 */
class RoboFile extends Tasks
{

    use PeridotTasks;

    public function specAll()
    {
        $result = $this->taskPeridot()
            ->directoryPath('spec')
            ->reporter('dot')
            ->run();

        return $result;
    }

    public function specCoveralls()
    {
        $configuration = BuilderConfiguration::loadFromFile('.coveralls.toml');
        $builder = CoverallsReportBuilder::fromConfiguration($configuration);
        $builder->build()->save()->upload();
    }

    public function specCoverallsSaveOnly()
    {
        $configuration = BuilderConfiguration::loadFromFile('.coveralls.toml');
        $builder = CoverallsReportBuilder::fromConfiguration($configuration);
        $builder->build()->save();
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
