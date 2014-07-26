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

use coverallskit\Environment;

/**
 * Class Travis
 * @package coverallskit\entity\service
 */
abstract class Travis implements TravisInterface
{

    /**
     * @var \coverallskit\Environment
     */
    protected $environment;

    /**
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getServiceJobId()
    {
        return $this->environment->get(static::ENV_JOB_ID);
    }

    public function getServiceName()
    {
        return static::NAME;
    }

    public function getCoverallsToken()
    {
        return $this->environment->get(static::ENV_COVERALLS_REPO_TOKEN_KEY);
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

}
