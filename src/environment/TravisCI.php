<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coveralls\environment;

class TravisCI implements TravisCIInterface
{

    protected $jobId;
    protected $serviceName;

    public function __construct($serviceName = self::SERVICE_CI)
    {
        $this->jobId = getenv(self::ENV_JOB_ID);
        $this->serviceName = $serviceName;
    }

    public function getJobId()
    {
        return $this->jobId;
    }

    public function getServiceName()
    {
        return $this->serviceName;
    }

}
