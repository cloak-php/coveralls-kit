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
use coverallskit\AttributePopulatable;


/**
 * Class AbstractService
 * @package coverallskit\entity\service
 */
abstract class AbstractService implements ServiceInterface
{

    use AttributePopulatable;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $jobNumberKey;

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

    /**
     * @return null|string
     */
    public function getServiceJobId()
    {
        return $this->environment->get($this->jobNumberKey);
    }

    /**
     * @return string
     */
    public function getServiceName()
    {
        return $this->name;
    }

    /**
     * @return null|string
     */
    public function getCoverallsToken()
    {
        return $this->environment->get(static::ENV_COVERALLS_REPO_TOKEN_KEY);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        $serviceName = $this->getServiceName();
        return empty($serviceName);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $values = [
            'service_job_id' => $this->getServiceJobId(),
            'service_name' => $this->getServiceName()
        ];

        return $values;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->toArray());
    }

}
