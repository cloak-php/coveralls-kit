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

use coverallskit\exception\FileNotFoundException;
use coverallskit\exception\NotSupportFileTypeException;
use coverallskit\Configuration;
use Symfony\Component\Yaml\Yaml;
use coverallskit\entity\Repository;
use Zend\Config\Config;


/**
 * Class ConfigurationLoadable
 * @package coverallskit
 */
trait ConfigurationLoadable
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
        $values = Yaml::parse($this->filePath);
        $config = new Config($values);

        $config->merge(new Config([
            self::CONFIG_FILE_KEY => $this->filePath,
            self::CONFIG_DIRECTORY_KEY => $this->directoryPath
        ]));

        return new Configuration($config);
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

}
