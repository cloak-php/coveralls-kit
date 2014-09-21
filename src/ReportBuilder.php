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
use coverallskit\entity\RepositoryInterface;
use coverallskit\entity\SourceFile;
use coverallskit\entity\collection\SourceFileCollection;
use coverallskit\entity\service\ServiceInterface;
use coverallskit\exception\RequiredException;

/**
 * Class ReportBuilder
 * @package coverallskit
 * @property string $reportFilePath
 * @property string $token
 * @property \coverallskit\entity\service\ServiceInterface $service
 * @property \coverallskit\entity\RepositoryInterface $repository
 * @property \coverallskit\entity\collection\SourceFileCollection $sourceFiles
 */
class ReportBuilder implements ReportBuilderInterface
{

    /**
     * @var string
     */
    protected $reportFilePath;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var \coverallskit\entity\service\ServiceInterface
     */
    protected $service;

    /**
     * @var \coverallskit\entity\RepositoryInterface
     */
    protected $repository;

    /**
     * @var \coverallskit\entity\collection\SourceFileCollection
     */
    protected $sourceFiles;


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
     * @param string $repositoryToken
     * @return $this
     */
    public function token($repositoryToken)
    {
        $this->token = $repositoryToken;
        return $this;
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
     * @param RepositoryInterface $repository
     * @return $this
     */
    public function repository(RepositoryInterface $repository)
    {
        $this->repository = $repository;
        return $this;
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
     * @throws RequiredException
     */
    protected function validate()
    {
        if (empty($this->repository)) {
            throw new RequiredException('repository');
        }

        if (empty($this->service)) {
            throw new RequiredException('service');
        }
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
        $this->validate();
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

    /**
     * @param string $name
     */
    public function __get($name)
    {
        return $this->$name;
    }

}
