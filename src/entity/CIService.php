<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace coverallskit\entity;

use coverallskit\AttributePopulatable;
use coverallskit\environment\EnvironmentAdapter;

/**
 * Class CIService
 */
class CIService implements ServiceEntity
{
    use AttributePopulatable;

    /**
     * @var \coverallskit\environment\EnvironmentAdapter
     */
    protected $adaptor;

    /**
     * @param EnvironmentAdapter $adaptor
     */
    public function __construct(EnvironmentAdapter $adaptor)
    {
        $this->adaptor = $adaptor;
    }

    /**
     * @return null|string
     */
    public function getServiceJobId()
    {
        return $this->adaptor->getBuildJobId();
    }

    /**
     * @return string
     */
    public function getServiceName()
    {
        return $this->adaptor->getName();
    }

    /**
     * @return null|string
     */
    public function getCoverallsToken()
    {
        return $this->adaptor->getCoverallsToken();
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
            'service_name' => $this->getServiceName(),
            'service_job_id' => $this->getServiceJobId()
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
