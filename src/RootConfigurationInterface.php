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
 * Interface RootConfigurationInterface
 * @package coverallskit
 */
interface RootConfigurationInterface extends ConfigurationInterface, ConfigurationLoaderInterface
{

    /**
     * @return string
     */
    public function getReportFileName();

    /**
     * @return string
     */
    public function getToken();

    /**
     * @return \coverallskit\entity\ServiceInterface
     */
    public function getService();

    /**
     * @return string
     */
    public function getRepository();

}
