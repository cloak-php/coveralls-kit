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

use coverallskit\entity\ReportInterface;
use Guzzle\Http\Client;
use Guzzle\Http\ClientInterface;

class ReportUpLoader implements ReportUpLoaderInterface
{

    protected $client = null;

    public function __construct(ClientInterface $client = null)
    {
        $httpClient = $client;

        if ($httpClient === null) {
            $httpClient = new Client();
        }
        $this->setClient($httpClient);
    }

    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function upload(ReportInterface $report)
    {
        $request = $this->getClient()->post(static::ENDPOINT_URL);
        $request->addPostFiles([
            static::JSON_FILE_POST_FIELD_NAME => $report->getName()
        ]);
        $request->send();
    }

}
