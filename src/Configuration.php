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

class Configuration
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $token;

    /**
     * @var \coverallskit\entity\service\ServiceUnterface
     */
    private $service;

    /**
     * @var string
     */
    private $repositoryDirectory;

    /**
     * @return string
     */
    public function getName()
    {
    }

    /**
     * @return string
     */
    public function getToken()
    {
    }

    /**
     * @return \coverallskit\entity\service\ServiceInterface
     */
    public function getService()
    {
    }

    /**
     * @return string
     */
    public function getRepositoryDirectory()
    {
    }

}
