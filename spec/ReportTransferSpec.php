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

use coverallskit\ReportTransfer;
use coverallskit\entity\Report;
use coverallskit\entity\Repository;
use coverallskit\entity\collection\SourceFileCollection;
use Prophecy\Prophet;
use Prophecy\Argument;

describe('ReportTransfer', function() {
    before(function() {
        $this->prophet = new Prophet();
    });
    after(function() {
        $this->prophet->checkPredictions();
    });
    describe('getClient', function() {
        before(function() {
            $this->uploader = new ReportTransfer();
        });
        context('When not specified client', function() {
            it('should return Guzzle\Http\Client instance', function() {
                $client = $this->uploader->getClient();
                expect($client)->toBeAnInstanceOf('GuzzleHttp\Client');
            });
        });
    });

    describe('upload', function() {
        before(function() {
            $this->service = $this->prophet->prophesize('coverallskit\entity\service\TravisInterface');
            $this->service->toArray()->shouldBeCalled()->willReturn([
                'service_job_id' => '10',
                'service_name' => 'travis-ci'
            ]);

            $this->report = new Report([
                'name' => __DIR__ . '/fixtures/coveralls.json',
                'token' => 'foo',
                'repository' => new Repository(__DIR__ . '/../'),
                'service' => $this->service->reveal(),
                'sourceFiles' => new SourceFileCollection()
            ]);

            $url = ReportTransfer::ENDPOINT_URL;
            $optionsCallback = Argument::that(function(array $options) {
                return isset($options['body']);
            });

            $this->client = $this->prophet->prophesize('GuzzleHttp\ClientInterface');
            $this->client->post($url, $optionsCallback)->shouldBeCalled();

            $this->uploader = new ReportTransfer($this->client->reveal());
        });
        it('should upload report file', function() {
            $this->uploader->upload($this->report);
        });
    });
});
