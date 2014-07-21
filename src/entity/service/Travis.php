<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\entity\service;

use coverallskit\AttributePopulatable;

class Travis implements TravisInterface
{

    use AttributePopulatable;

    protected $serviceJobId;
    protected $serviceName;

    public function __construct($serviceName = self::SERVICE_CI)
    {
        $this->serviceJobId = getenv(self::ENV_JOB_ID);
        $this->serviceName = $serviceName;
    }

    public function getServiceJobId()
    {
        return $this->serviceJobId;
    }

    public function getServiceName()
    {
        return $this->serviceName;
    }

    public function getCoverallsToken()
    {
        return getenv(static::ENV_COVERALLS_REPO_TOKEN_KEY);
    }

    public function isEmpty()
    {
        $serviceName = $this->getServiceName();
        return empty($serviceName);
    }

    public function toArray()
    {
        $values = [
            'service_job_id' => $this->getServiceJobId(),
            'service_name' => $this->getServiceName()
        ];

        return $values;
    }

    public function __toString()
    {
        return json_encode($this->toArray());
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
