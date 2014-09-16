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

use coverallskit\exception\NotSupportFileTypeException;

describe('NotSupportFileTypeException', function() {
    describe('getMessage', function() {
        context('when with extention', function() {
            before(function() {
                $this->exception = new NotSupportFileTypeException("path/to/config.ini");
            });
            it('should return message', function() {
                $message = "The '.ini' file type is not supported.";
                expect($this->exception->getMessage())->toEqual($message);
            });
        });
        context('when not with extention', function() {
            before(function() {
                $this->exception = new NotSupportFileTypeException("path/to/config");
            });
            it('should return message', function() {
                $message = "The 'path/to/config' file type is not supported.";
                expect($this->exception->getMessage())->toEqual($message);
            });
        });
    });
});
