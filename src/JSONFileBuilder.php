<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coveralls;

use coveralls\entity\JSONFile;
use coveralls\entity\RepositoryInterface;
use coveralls\entity\SourceFile;
use coveralls\entity\collection\SourceFileCollection;
use coveralls\entity\service\ServiceInterface;

class JSONFileBuilder
{

    protected $token = null;
    protected $service = null;
    protected $repository = null;
    protected $sourceFiles = null;

    public function __construct()
    {
        $this->sourceFiles = new SourceFileCollection();
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

    public function build()
    {
        return new JSONFile([
            'token' => $this->token,
            'repository' => $this->repository,
            'service' => $this->service,
            'sourceFiles' => $this->sourceFiles,
            'runAt' => date('Y-m-d H:i:s O') ////2013-02-18 00:52:48 -0800
        ]);
    }

}
