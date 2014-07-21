<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit;

use coverallskit\entity\service\ServiceInterface;
use coverallskit\entity\RepositoryInterface;
use coverallskit\ReportBuilderInterface;

/**
 * Class Configuration
 * @package coverallskit
 */
class Configuration
{

    use AttributePopulatable;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $token;

    /**
     * @var \coverallskit\entity\service\ServiceInterface
     */
    private $service;

    /**
     * @var \coverallskit\entity\RepositoryInterface
     */
    private $repository;

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->populate($values);
    }

    /**
     * @param ServiceInterface $service
     */
    private function setService(ServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param RepositoryInterface $service
     */
    private function setRepository(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return \coverallskit\entity\service\ServiceInterface
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @return string
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param ReportBuilderInterface $builder
     */
    public function applyTo(ReportBuilderInterface $builder)
    {
        $builder->name($this->getName());
        $builder->token($this->getToken());
        $builder->service($this->getService());
        $builder->repository($this->getRepository());
    }

}
