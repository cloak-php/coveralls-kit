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

use coverallskit\ReportBuilder;
use coverallskit\entity\CIService;
use coverallskit\entity\GitRepository;
use coverallskit\Environment;
use coverallskit\environment\AdaptorResolver;
use Zend\Config\Config;
use Eloquent\Pathogen\AbsolutePath;


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
     * @var \coverallskit\environment\AdaptorResolver
     */
    private $adaptorResolver;


    /**
     * @param Config $config
     * @param AbsolutePath $rootPath
     */
    public function __construct(Config $config, AbsolutePath $rootPath)
    {
        $this->adaptorResolver = new AdaptorResolver(new Environment($_SERVER));

        parent::__construct($config, $rootPath);
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->get(self::TOKEN_KEY);
    }

    /**
     * @return \coverallskit\entity\ServiceEntity
     */
    public function getService()
    {
        $serviceName = $this->get(self::SERVICE_KEY);

        if ($serviceName === null) {
            $adaptor = $this->adaptorResolver->resolveByEnvironment();
        } else {
            $adaptor = $this->adaptorResolver->resolveByName($serviceName);
        }

        return new CIService($adaptor);
    }

    /**
     * @return \coverallskit\entity\RepositoryEntity
     */
    public function getRepository()
    {
        $directory = $this->get(self::REPOSITORY_DIRECTORY_KEY);
        $repository = $this->repositoryFromPath($directory);

        return $repository;
    }

    /**
     * @param ReportBuilder $builder
     * @return ReportBuilder
     */
    public function applyTo(ReportBuilder $builder)
    {
        $builder->token($this->getToken())
            ->service($this->getService())
            ->repository($this->getRepository());

        return $builder;
    }

    /**
     * @param string $path
     * @return \coverallskit\entity\RepositoryEntity
     */
    private function repositoryFromPath($path)
    {
        $directory = $this->resolvePath($path);
        $repository = new GitRepository($directory);

        return $repository;
    }

}
