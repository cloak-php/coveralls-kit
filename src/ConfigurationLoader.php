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
use coverallskit\entity\service\Travis;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ConfigurationLoader
 * @package coverallskit
 */
class ConfigurationLoader implements ConfigurationLoaderInterface
{

    /**
     * @param string $file
     * @return Configuration
     * @throws FileNotFoundException
     */
    public function loadFromFile($file)
    {
        if ($this->fileExists($file) === false) {
            throw new FileNotFoundException($file);
        }

        if ($this->isYamlFile($file)) {
            return $this->loadFromYamlFile($file);
        }

        throw new NotSupportFileTypeException($file);
    }

    /**
     * @param string $file
     * @return Configuration
     * @throws FileNotFoundException
     */
    private function loadFromYamlFile($file)
    {

        $attributes = $values = Yaml::parse($file);

        if (isset($values['service'])) {
            $attributes['service'] = $this->serviceFromString($values['service']);
        }

        return new Configuration($attributes);
    }

    /**
     * @param $file
     * @return boolean
     */
    private function fileExists($file)
    {
        return file_exists($file);
    }

    /**
     * @param $file
     * @return boolean
     */
    private function isYamlFile($file)
    {
        return preg_match('/(\.yml|yaml)$/', $file) === 1;
    }

    /**
     * @param string $serviveName
     * @return \coverallskit\entity\service\ServiceInterface
     */
    private function serviceFromString($serviveName)
    {
        if ($serviveName === 'travis-ci') {
            return Travis::travisCI();
        } else if ($serviveName === 'travis-pro') {
            return Travis::travisPro();
        }
    }

}
