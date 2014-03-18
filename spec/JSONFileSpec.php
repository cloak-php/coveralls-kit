<?php

namespace coveralls\spec;

use coveralls\JSONFile;
use pho;

describe('JSONFile', function() {
    before(function() {
        $this->jsonFile = new JSONFile(array(
            'repositoryToken' => 'foo'
        ));
    });
    describe('repositoryToken', function() {
        it('should return repository token string', function() {
            expect($this->jsonFile->repositoryToken)->toBe('foo');
        });
    });
});
