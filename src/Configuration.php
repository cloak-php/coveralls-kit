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
use coverallskit\report\ParserRegistry;
use coverallskit\exception\FileNotFoundException;
use coverallskit\exception\NotSupportFileTypeException;
use coverallskit\configuration\Report;
use Zend\Config\Config;
use Symfony\Component\Yaml\Yaml;


/**
 * Class Configuration
 * @package coverallskit
 */
class Configuration implements RootConfigurationInterface
{

    /**
     * @var \Zend\Config\Config
     */
    private $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config = null)
    {
        $userConfig = $config ?: new Config([]);

        $current = $this->getDefaultConfigration();
        $current->merge($userConfig);

        $this->config = $current;
    }

    /**
     * @return string
     */
    public function getReportFileName()
    {
        $reportFileConfig = $this->getReportConfiguration();
        return $reportFileConfig->getReportFileName();
    }

    /**
     * @return string
     */
    public function getCoverageReportFileType()
    {
        $reportFileConfig = $this->getReportConfiguration();
        return $reportFileConfig->getCoverageReportFileType();
    }

    /**
     * @return string
     */
    public function getCoverageReportFilePath()
    {
        $reportFileConfig = $this->getReportConfiguration();
        return $reportFileConfig->getCoverageReportFilePath();
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
        $builder->token($this->getToken())
            ->service($this->getService())
            ->repository($this->getRepository());

        $report = $this->getReportConfiguration();
        $report->applyTo($builder);

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
     * The directory path where the configuration file
     *
     * @return string
     */
    public function getDirectoryPath()
    {
        $directoryPath = $this->config->get(self::CONFIG_DIRECTORY_KEY, getcwd());
        $directoryPath = realpath($directoryPath) . DIRECTORY_SEPARATOR;

        return $directoryPath;
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

    /**
     * @return Report
     */
    private function getReportConfiguration()
    {
        $reportFile = $this->config->get(self::REPORT_FILE_KEY);
        return new Report($reportFile, $this);
    }

    /**
     * @param string $file
     * @return Configuration
     * @throws \coverallskit\exception\NotSupportFileTypeException
     * @throws \coverallskit\exception\FileNotFoundException
     */
    public static function loadFromFile($file)
    {
        if (file_exists($file) === false) {
            throw new FileNotFoundException($file);
        }

        if (preg_match('/(\.yml|yaml)$/', $file) !== 1) {
            throw new NotSupportFileTypeException($file);
        }

        $values = Yaml::parse($file);
        $config = new Config($values);

        $config->merge(new Config([
            self::CONFIG_FILE_KEY => $file,
            self::CONFIG_DIRECTORY_KEY => dirname(realpath($file)) . DIRECTORY_SEPARATOR
        ]));

        return new Configuration($config);
    }

}
