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
 * Interface ConfigurationLoaderInterface
 * @package coverallskit
 */
interface ConfigurationLoaderInterface
{

    const CONFIG_FILE_KEY = 'configurationFile';
    const CONFIG_DIRECTORY_KEY = 'configurationFileDirectory';

    /**
     * @param string $file
     * @return Configuration
     */
    public function loadFromFile($file);

}
