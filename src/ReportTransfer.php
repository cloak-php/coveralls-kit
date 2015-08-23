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

use coverallskit\entity\ReportEntity;
use GuzzleHttp\ClientInterface;


/**
 * Interface ReportTransfer
 * @package coverallskit
 */
interface ReportTransfer
{

    const HTTP_METHOD = 'POST';
    const ENDPOINT_URL = 'https://coveralls.io/api/v1/jobs';
    const JSON_FILE_POST_FIELD_NAME = 'json_file';

    /**
     * @param \GuzzleHttp\ClientInterface $client
     * @return void
     */
    public function setClient(ClientInterface $client);

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    public function getClient();

    /**
     * @param \coverallskit\entity\ReportEntity $report
     * @return mixed
     */
    public function upload(ReportEntity $report);

}
