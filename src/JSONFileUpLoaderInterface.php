<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coveralls;

use coveralls\entity\JSONFileInterface;
use Guzzle\Http\ClientInterface;

interface JSONFileUpLoaderInterface
{

    const ENDPOINT_URL = 'https://coveralls.io/api/v1/jobs';
    const JSON_FILE_POST_FIELD_NAME = 'json_file';

    /**
     * @param Guzzle\Http\ClientInterface $client
     */
    public function setClient(ClientInterface $client);

    /**
     * @return Guzzle\Http\ClientInterface
     */
    public function getClient();

    /**
     * @param entity\JSONFileInterface $jsonFile
     */
    public function upload(JSONFileInterface $jsonFile);

}
