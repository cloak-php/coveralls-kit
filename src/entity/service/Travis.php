<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coveralls\entity\service;

class Travis implements TravisInterface
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

    public function toArray()
    {
        $values = [
            'service_job_id' => $this->getJobId(),
            'service_name' => $this->getServiceName()
        ];

        return $values;
    }

    public static function travisCI()
    {
        return new static();
    }

    public static function travisPro()
    {
        return new static(self::SERVICE_PRO);
    }

}
