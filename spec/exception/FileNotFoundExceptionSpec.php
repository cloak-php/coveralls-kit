<?php

namespace coveralls\spec;

use coveralls\exception\FileNotFoundException;

describe('FileNotFoundException', function() {
    describe('getMessage', function() {
        before(function() {
            $this->exception = new FileNotFoundException('foo.php');
        });
        it('should return message', function() {
            expect($this->exception->getMessage())->toEqual('Can not find the file foo.php');
        });
    });
});
