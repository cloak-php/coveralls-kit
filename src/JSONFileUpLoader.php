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

class JSONFileUpLoader
{

    protected $client = null;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function upload(JSONFileInterface $jsonFile)
    {
        $request = $this->client->post('https://coveralls.io/api/v1/jobs');
        $request->addPostFiles([
            'json_file' => $jsonFile->getName()
        ]);
        $request->send();
    }

}
