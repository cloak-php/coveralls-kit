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

    const TOKEN_KEY = 'token';
    const SERVICE_KEY = 'service';
    const REPORT_FILE_KEY = 'reportFile';
    const INPUT_REPORT_FILE_KEY = 'input';
    const INPUT_REPORT_FILE_TYPE_KEY = 'type';
    const INPUT_REPORT_FILE_PATH_KEY = 'file';
    const OUTPUT_REPORT_FILE_KEY = 'output';
    const REPOSITORY_DIRECTORY_KEY = 'repositoryDirectory';

    /**
     * @return string
     */
    public function getReportFileName();

    /**
     * @return string
     */
    public function getToken();

    /**
     * @return \coverallskit\entity\service\ServiceInterface
     */
    public function getService();

    /**
     * @return string
     */
    public function getRepository();

}
