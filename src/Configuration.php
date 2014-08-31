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

use coverallskit\entity\Repository;
use coverallskit\configuration\ConfigurationLoadable;
use Zend\Config\Config;


/**
 * Class Configuration
 * @package coverallskit
 */
class Configuration implements ConfigurationInterface
{
    use ConfigurationLoadable;

    /**
     * @var \Zend\Config\Config
     */
    private $config;

    /**
     * @param array $values
     */
    public function __construct(Config $config)
    {
        $current = $this->getDefaultConfigration();
        $current->merge($config);

        $this->config = $current;
    }

    /**
     * @return string
     */
    public function getReportFileName()
    {
        $reportFile = $this->config->get(self::REPORT_FILE_KEY);
        $path = $reportFile->get(self::OUTPUT_REPORT_FILE_KEY);
        return $this->resolvePath($path);
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->config->get(self::TOKEN_KEY);
    }

    /**
     * @return \coverallskit\entity\service\ServiceInterface
     */
    public function getService()
    {
        $serviceName = $this->config->get(self::SERVICE_KEY);
        $service = $this->serviceFromString($serviceName);

        return $service;
    }

    /**
     * @return entity\Repository
     */
    public function getRepository()
    {
        $directory = $this->config->get(self::REPOSITORY_DIRECTORY_KEY);
        $repository = $this->repositoryFromPath($directory);

        return $repository;
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
        $directoryPath = $this->config->get(self::CONFIG_DIRECTORY_KEY, getcwd());
        $directoryPath = realpath($directoryPath) . DIRECTORY_SEPARATOR;

        $relativePath = preg_replace('/^(\\/|\\.\\/)*(.+)/', '$2', $name);

        return $directoryPath . $relativePath;
    }

    /**
     * @return Config
     */
    protected function getDefaultConfigration()
    {
        $config = new Config([
            self::TOKEN_KEY => null,
            self::SERVICE_KEY => 'travis-ci',
            self::REPORT_FILE_KEY => [
                self::OUTPUT_REPORT_FILE_KEY => 'coveralls.json'
            ],
            self::REPOSITORY_DIRECTORY_KEY => '.'
        ]);

        return $config;
    }

}
