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


/**
 * Class Configuration
 * @package coverallskit
 */
class Configuration implements ConfigurationInterface
{

    use AttributePopulatable;

    /**
     * @var string
     */
    private $reportFile;

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
    public function getReportFileName()
    {
        return $this->reportFile;
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
     * @return ReportBuilderInterface
     */
    public function applyTo(ReportBuilderInterface $builder)
    {
        $builder->reportFilePath($this->getReportFileName())
            ->token($this->getToken())
            ->service($this->getService())
            ->repository($this->getRepository());

        return $builder;
    }

}
