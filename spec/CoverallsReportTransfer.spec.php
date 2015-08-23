<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace coverallskit\spec;

use coverallskit\CoverallsReportTransfer;
use coverallskit\entity\CIService;
use coverallskit\entity\collection\SourceFileCollection;
use coverallskit\entity\CoverallsReport;
use coverallskit\entity\GitRepository;
use coverallskit\Environment;
use coverallskit\environment\TravisCI;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Prophecy\Argument;
use Prophecy\Prophet;

describe(CoverallsReportTransfer::class, function () {
    describe('getClient', function () {
        beforeEach(function () {
            $this->uploader = new CoverallsReportTransfer();
        });
        context('when not specified client', function () {
            it('should return GuzzleHttp\Client instance', function () {
                $client = $this->uploader->getClient();
                expect($client)->toBeAnInstanceOf(Client::class);
            });
        });
    });

    describe('upload', function () {
        beforeEach(function () {
            $environment = new Environment([
                'CI' => 'true',
                'TRAVIS' => 'true',
                'TRAVIS_JOB_ID' => '10',
                'COVERALLS_REPO_TOKEN' => 'token'
            ]);
            $adaptor = new TravisCI($environment);
            $service = new CIService($adaptor);

            $this->report = new CoverallsReport([
                'name' => __DIR__ . '/fixtures/coveralls.json',
                'token' => 'foo',
                'repository' => new GitRepository(__DIR__ . '/../'),
                'service' => $service,
                'sourceFiles' => new SourceFileCollection()
            ]);

            $url = CoverallsReportTransfer::ENDPOINT_URL;
            $optionsCallback = Argument::that(function (array $options) {
                return isset($options['multipart']);
            });

            $this->prophet = new Prophet();

            $this->client = $this->prophet->prophesize(ClientInterface::class);
            $this->client->request('POST', $url, $optionsCallback)->shouldBeCalled();

            $this->uploader = new CoverallsReportTransfer($this->client->reveal());
            $this->uploader->upload($this->report);
        });
        it('should upload report file', function () {
            $this->prophet->checkPredictions();
        });
    });
});
