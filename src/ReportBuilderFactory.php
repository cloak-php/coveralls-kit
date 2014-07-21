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

/**
 * Class ReportBuilderFactory
 * @package coverallskit
 */
class ReportBuilderFactory
{

    /**
     * @var ConfigurationLoader
     */
    private $loader;

    public function __construct()
    {
        $this->loader = new ConfigurationLoader();
    }

    /**
     * @param string $configurationFile
     * @return ReportBuilder
     */
    public function createFromConfigurationFile($configurationFile)
    {
        $configuration = $this->loader->loadFromFile($configurationFile);
        return $configuration->applyTo(new ReportBuilder());
    }

}
