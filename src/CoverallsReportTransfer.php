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
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

/**
 * Class CoverallsReportTransfer
 */
class CoverallsReportTransfer implements ReportTransfer
{
    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client = null)
    {
        $httpClient = $client;

        if ($httpClient === null) {
            $httpClient = new Client();
        }
        $this->setClient($httpClient);
    }

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param ReportEntity $report
     */
    public function upload(ReportEntity $report)
    {
        $stream = fopen($report->getName(), 'r');

        $client = $this->getClient();
        $client->request(self::HTTP_METHOD, self::ENDPOINT_URL, [
            'multipart' => [
                [
                    'name' => self::JSON_FILE_POST_FIELD_NAME,
                    'contents' => $stream
                ]
            ]
        ]);
    }
}
