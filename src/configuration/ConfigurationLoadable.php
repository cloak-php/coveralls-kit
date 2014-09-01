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
