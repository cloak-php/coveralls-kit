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
 * Interface Configuration
 * @package coverallskit
 */
interface ConfigurationInterface
{
    const CONFIG_FILE_KEY = 'configurationFile';
    const CONFIG_DIRECTORY_KEY = 'configurationFileDirectory';

    const TOKEN_KEY = 'token';
    const SERVICE_KEY = 'service';
    const REPORT_FILE_KEY = 'reportFile';
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

    /**
     * @param ReportBuilderInterface $builder
     * @return ReportBuilderInterface
     */
    public function applyTo(ReportBuilderInterface $builder);

}
