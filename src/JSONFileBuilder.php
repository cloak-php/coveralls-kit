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

use coveralls\JSONFile;
use coveralls\jsonfile\SourceFile;
use coveralls\jsonfile\SourceFileCollection;
use coveralls\environment\EnvironmentInterface;

class JSONFileBuilder
{

    protected $token = null;
    protected $sourceFiles = null;
    protected $environment = null;

    public function __construct()
    {
        $this->sourceFiles = new SourceFileCollection();
    }

    public function token($repositoryToken)
    {
        $this->token = $repositoryToken;
        return $this;
    }

    public function environment(EnvironmentInterface $environment)
    {
        $this->environment = $environment;
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
            'environment' => $this->environment,
            'sourceFiles' => $this->sourceFiles,
            'runAt' => date('Y-m-d H:i:s O') ////2013-02-18 00:52:48 -0800
        ]);
    }

}
