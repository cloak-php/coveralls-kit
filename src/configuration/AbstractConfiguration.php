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
use coverallskit\entity\Repository;
use Zend\Config\Config;
use Eloquent\Pathogen\Factory\PathFactory;
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
     * @var \coverallskit\RootConfigurationInterface
     */
    private $rootConfig;


    /**
     * @param Config $config
     */
    public function __construct(Config $config, RootConfigurationInterface $rootConfig)
    {
        $this->config = $config;
        $this->rootConfig = $rootConfig;
    }

    /**
     * @return RootConfigurationInterface
     */
    public function getRoot()
    {
        return $this->rootConfig;
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
