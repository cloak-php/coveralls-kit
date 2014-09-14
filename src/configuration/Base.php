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

use coverallskit\ConfigurationInterface;
use coverallskit\RootConfigurationInterface;
use coverallskit\ReportBuilderInterface;
use coverallskit\entity\Repository;
use coverallskit\ServiceRegistry;
use Zend\Config\Config;
use Eloquent\Pathogen\Factory\PathFactory;
use Eloquent\Pathogen\RelativePath;
use Eloquent\Pathogen\AbsolutePath;
use Eloquent\Pathogen\Exception\NonRelativePathException;

/**
 * Class Base
 * @package coverallskit
 */
class Base implements ConfigurationInterface
{

    const TOKEN_KEY = 'token';
    const SERVICE_KEY = 'service';
    const REPOSITORY_DIRECTORY_KEY = 'repositoryDirectory';

    /**
     * @var \coverallskit\RootConfigurationInterface
     */
    private $rootConfig;

    /**
     * @var \Zend\Config\Config
     */
    private $baseConfig;

    /**
     * @param Config $config
     */
    public function __construct(Config $baseConfig, RootConfigurationInterface $rootConfig)
    {
        $this->rootConfig = $rootConfig;
        $this->baseConfig = $baseConfig;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->baseConfig->get(self::TOKEN_KEY);
    }

    /**
     * @return \coverallskit\entity\service\ServiceInterface
     */
    public function getService()
    {
        $serviceName = $this->baseConfig->get(self::SERVICE_KEY);
        $service = $this->serviceFromString($serviceName);

        return $service;
    }

    /**
     * @return \coverallskit\entity\Repository
     */
    public function getRepository()
    {
        $directory = $this->baseConfig->get(self::REPOSITORY_DIRECTORY_KEY);
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
     * @param string $serviceName
     * @return \coverallskit\entity\service\ServiceInterface
     */
    private function serviceFromString($serviceName)
    {
        $registry = new ServiceRegistry();
        $service = $registry->get($serviceName);

        return $service;
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

    /**
     * @param string $name
     * @return string
     */
    private function resolvePath($name)
    {
        $directoryPath = $this->rootConfig->getDirectoryPath();

        $factory = PathFactory::instance();
        $rootPath = $factory->create($directoryPath);

        try {
            $path = RelativePath::fromString($name);
        } catch (NonRelativePathException $exception) {
            $path = AbsolutePath::fromString($name);
        }
        $resultPath = $rootPath->resolve($path);

        return $resultPath->normalize()->string();
    }

}
