<?php

namespace coveralls\environment;

class TravisCI
{

    protected $jobId;
    protected $serviceName;

    public function __construct($serviceName = 'travis-ci')
    {
        $this->jobId = getenv('TRAVIS_JOB_ID');
        $this->serviceName = $serviceName;
    }

    public function __get($name)
    {
        return $this->$name;            
    }

}
