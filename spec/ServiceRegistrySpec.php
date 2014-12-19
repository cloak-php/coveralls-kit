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

use coverallskit\ServiceRegistry;

describe('ServiceRegistry', function() {
    beforeEach(function() {
        $this->registry = new ServiceRegistry();
    });
    describe('get', function() {
        context('when travis-ci', function() {
            it('should return TravisCI instance', function() {
                expect($this->registry->get('travis-ci'))->toBeAnInstanceOf('coverallskit\entity\service\travis\TravisCI');
            });
        });
        context('when travis-pro', function() {
            it('should return TravisPro instance', function() {
                expect($this->registry->get('travis-pro'))->toBeAnInstanceOf('coverallskit\entity\service\travis\TravisPro');
            });
        });
        context('when key not exist', function() {
            it('should return coverallskit\exception\NotSupportServiceException instance', function() {
                expect(function() {
                    $this->registry->get('foo');
                })->toThrow('coverallskit\exception\NotSupportServiceException');
            });
        });
    });

});
