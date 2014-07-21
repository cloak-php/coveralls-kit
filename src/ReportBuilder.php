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

/**
 * Class ReportBuilder
 * @package coverallskit
 */
class ReportBuilder implements ReportBuilderInterface
{

    /**
     * @var string
     */
    protected $name;

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

    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    public function token($repositoryToken)
    {
        $this->token = $repositoryToken;
        return $this;
    }

    public function service(ServiceInterface $service)
    {
        $this->service = $service;
        return $this;
    }

    public function repository(RepositoryInterface $repository)
    {
        $this->repository = $repository;
        return $this;
    }

    public function addSource(SourceFile $source)
    {
        $this->sourceFiles->add($source);
        return $this;
    }

    /**
     * @return \coverallskit\entity\ReportInterface
     */
    public function build()
    {
        if (empty($this->token)) {
            $this->token = $this->service->getCoverallsToken();
        }

        return new Report([
            'name' => $this->name,
            'token' => $this->token,
            'repository' => $this->repository,
            'service' => $this->service,
            'sourceFiles' => $this->sourceFiles,
            'runAt' => date('Y-m-d H:i:s O') ////2013-02-18 00:52:48 -0800
        ]);
    }

}
