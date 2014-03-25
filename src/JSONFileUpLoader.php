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
use Guzzle\Http\Client;
use Guzzle\Http\ClientInterface;

class JSONFileUpLoader implements JSONFileUpLoaderInterface
{

    protected $client = null;

    public function __construct(ClientInterface $client = null)
    {
        $this->client = ($client === null) ? new Client() : $client;
    }

    public function upload(JSONFileInterface $jsonFile)
    {
        $request = $this->client->post(static::ENDPOINT_URL);
        $request->addPostFiles([
            static::JSON_FILE_POST_FIELD_NAME => $jsonFile->getName()
        ]);
        $request->send();
    }

}
