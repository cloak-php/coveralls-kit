<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\configuration;

use coverallskit\ReportBuilderInterface;
use coverallskit\entity\Service;
use coverallskit\entity\Repository;
use coverallskit\ServiceRegistry;
use coverallskit\Environment;
use coverallskit\environment\AdaptorDetector;
use coverallskit\exception\EnvironmentAdaptorNotFoundException;


/**
 * Class Basic
 * @package coverallskit
 */
class Basic extends AbstractConfiguration
{

    const TOKEN_KEY = 'token';
    const SERVICE_KEY = 'service';
    const REPOSITORY_DIRECTORY_KEY = 'repositoryDirectory';

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->get(self::TOKEN_KEY);
    }

    /**
     * @return \coverallskit\entity\ServiceInterface
     * FIXME Fix because code is terrible
     */
     public function getService()
     {
         $service = null;
         $serviceName = $this->get(self::SERVICE_KEY);

        if ($serviceName === null) {
            $service = $this->serviceFromEnvironment();
        } else {
            $service = $this->serviceFromString($serviceName);
        }

        return $service;
    }

    /**
     * @return \coverallskit\entity\Repository
     */
    public function getRepository()
    {
        $directory = $this->get(self::REPOSITORY_DIRECTORY_KEY);
        $repository = $this->repositoryFromPath($directory);

        return $repository;
    }

    /**
     * @param ReportBuilderInterface $builder
     * @return ReportBuilderInterface
     */
    public function applyTo(ReportBuilderInterface $builder)
    {
        $builder->token($this->getToken())
            ->service($this->getService())
            ->repository($this->getRepository());

        return $builder;
    }

    /**
     * @return \coverallskit\entity\ServiceInterface
     */
    private function serviceFromEnvironment()
    {
        $service = null;
        $adaptorDetector = new AdaptorDetector(new Environment($_SERVER));

        try {
            $adaptor = $adaptorDetector->resolveByEnvironment();
            $service = new Service($adaptor);
        } catch (EnvironmentAdaptorNotFoundException $exception) {
            return $service;
        }

        return $service;
    }

    /**
     * @param string $serviceName
     * @return \coverallskit\entity\ServiceInterface
     */
    private function serviceFromString($serviceName)
    {
        $adaptorDetector = new AdaptorDetector(new Environment($_SERVER));
        $adaptor = $adaptorDetector->resolveByName($serviceName);

        return new Service($adaptor);
    }

    /**
     * @param string $path
     * @return \coverallskit\entity\Repository
     */
    private function repositoryFromPath($path)
    {
        $directory = $this->resolvePath($path);
        $repository = new Repository($directory);

        return $repository;
    }

}
