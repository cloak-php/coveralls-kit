<?php

namespace coveralls\environment;

interface TravisCIInterface extends EnvironmentInterface
{

    const SERVICE_CI = 'travis-ci';
    const SERVICE_PRO = 'travis-pro';

    const ENV_JOB_ID = 'TRAVIS_JOB_ID';

}
