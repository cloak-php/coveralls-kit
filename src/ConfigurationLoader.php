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

use coverallskit\exception\FileNotFoundException;
use coverallskit\exception\NotSupportFileTypeException;
use Symfony\Component\Yaml\Yaml;
use coverallskit\entity\Repository;

/**
 * Class ConfigurationLoader
 * @package coverallskit
 */
class ConfigurationLoader implements ConfigurationLoaderInterface
{

    /**
     * @var string
     */
    private $filePath;

    /**
     * @var string
     */
    private $directoryPath;


    /**
     * @param string $file
     * @return Configuration
     * @throws FileNotFoundException
     */
    public function loadFromFile($file)
    {
        $this->setConfigurationFilePath($file);

        if ($this->fileExists() === false) {
            throw new FileNotFoundException($this->filePath);
        }

        if ($this->isYamlFile()) {
            return $this->loadFromYamlFile();
        }

        throw new NotSupportFileTypeException($this->filePath);
    }

    /**
     * @return Configuration
     * @throws FileNotFoundException
     */
    private function loadFromYamlFile()
    {

        $attributes = [];
        $values = Yaml::parse($this->filePath);

        if (isset($values['reportFile'])) {
            $attributes['reportFile'] = $this->resolvePath($values['reportFile']);
        }

        if (isset($values['token'])) {
            $attributes['token'] = $values['token'];
        }

        if (isset($values['service'])) {
            $attributes['service'] = $this->serviceFromString($values['service']);
        }

        if (isset($values['repositoryDirectory'])) {
            $path = $values['repositoryDirectory'];
            $attributes['repository'] = $this->repositoryFromPath($path);
        }

        return new Configuration($attributes);
    }

    /**
     * @param string $path
     */
    private function setConfigurationFilePath($path)
    {
        $this->filePath = $path;
        $this->directoryPath = dirname(realpath($this->filePath)) . DIRECTORY_SEPARATOR;
    }

    /**
     * @return boolean
     */
    private function fileExists()
    {
        return file_exists($this->filePath);
    }

    /**
     * @return boolean
     */
    private function isYamlFile()
    {
        return preg_match('/(\.yml|yaml)$/', $this->filePath) === 1;
    }

    /**
     * @param string $serviveName
     * @return \coverallskit\entity\service\ServiceInterface
     */
    private function serviceFromString($serviveName)
    {
        $registry = new ServiceRegistry();
        $service = $registry->get($serviveName);

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
        $relativePath = preg_replace('/^(\\/|\\.\\/)*(.+)/', '$2', $name);
        return realpath($this->directoryPath . $relativePath);
    }

}
