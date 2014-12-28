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
use Zend\Config\Config;
use Eloquent\Pathogen\RelativePath;
use Eloquent\Pathogen\AbsolutePath;
use Eloquent\Pathogen\Exception\NonRelativePathException;


/**
 * Class AbstractConfiguration
 * @package coverallskit\configuration
 */
abstract class AbstractConfiguration implements ConfigurationInterface
{

    /**
     * @var \Zend\Config\Config
     */
    private $config;

    /**
     * @var \Eloquent\Pathogen\AbsolutePath
     */
    private $rootPath;

    /**
     * @param Config $config
     */
    public function __construct(Config $config, AbsolutePath $rootPath)
    {
        $this->config = $config;
        $this->rootPath = $rootPath;
    }

    /**
     * @param string $key
     * @param mixed|null $defaultValue
     * @return mixed
     */
    protected function get($key, $defaultValue = null)
    {
        return $this->config->get($key, $defaultValue);
    }

    /**
     * @param string $name
     * @return string
     */
    protected function resolvePath($name)
    {
        try {
            $path = RelativePath::fromString($name);
        } catch (NonRelativePathException $exception) {
            $path = AbsolutePath::fromString($name);
        }
        $resultPath = $this->rootPath->resolve($path);

        return $resultPath->normalize()->string();
    }

}
