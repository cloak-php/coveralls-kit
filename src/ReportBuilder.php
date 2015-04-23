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

use coverallskit\entity\Report;
use coverallskit\entity\RepositoryEntity;
use coverallskit\entity\SourceFile;
use coverallskit\entity\collection\SourceFileCollection;
use coverallskit\entity\ServiceInterface;


/**
 * Class ReportBuilder
 * @package coverallskit
 */
class ReportBuilder implements ReportBuilderInterface
{

    /**
     * @var string
     */
    private $reportFilePath;

    /**
     * @var string
     */
    private $token;

    /**
     * @var \coverallskit\entity\ServiceInterface
     */
    private $service;

    /**
     * @var \coverallskit\entity\RepositoryEntity
     */
    private $repository;

    /**
     * @var \coverallskit\entity\collection\SourceFileCollection
     */
    private $sourceFiles;


    public function __construct()
    {
        $this->sourceFiles = new SourceFileCollection();
    }

    /**
     * @param string $reportFilePath
     * @return $this
     */
    public function reportFilePath($reportFilePath)
    {
        $this->reportFilePath = $reportFilePath;
        return $this;
    }

    /**
     * @return string
     */
    public function getReportFilePath()
    {
        return $this->reportFilePath;
    }

    /**
     * @param string $repositoryToken
     * @return $this
     */
    public function token($repositoryToken)
    {
        $this->token = $repositoryToken;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param ServiceInterface $service
     * @return $this
     */
    public function service(ServiceInterface $service)
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return ServiceInterface
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param RepositoryEntity $repository
     * @return $this
     */
    public function repository(RepositoryEntity $repository)
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * @return RepositoryEntity
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param SourceFile $source
     * @return $this
     */
    public function addSource(SourceFile $source)
    {
        $this->sourceFiles->add($source);
        return $this;
    }

    /**
     * @param SourceFileCollection $sources
     * @return $this
     */
    public function addSources(SourceFileCollection $sources)
    {
        foreach ($sources as $source) {
            $this->addSource($source);
        }
        return $this;
    }

    /**
     * @return SourceFileCollection
     */
    public function getSources()
    {
        return $this->sourceFiles;
    }

    protected function prepareBuild()
    {
        if (empty($this->token)) {
            $this->token = $this->service->getCoverallsToken();
        }
    }

    /**
     * @return \coverallskit\entity\ReportInterface
     */
    public function build()
    {
        $this->prepareBuild();

        return new Report([
            'name' => $this->reportFilePath,
            'token' => $this->token,
            'repository' => $this->repository,
            'service' => $this->service,
            'sourceFiles' => $this->sourceFiles,
            'runAt' => date('Y-m-d H:i:s O') ////2013-02-18 00:52:48 -0800
        ]);
    }

    /**
     * @param ConfigurationInterface $config
     * @return ReportBuilderInterface
     */
    public static function fromConfiguration(ConfigurationInterface $config)
    {
        return $config->applyTo(new static());
    }

}
