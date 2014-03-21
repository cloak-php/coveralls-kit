<?php

namespace coveralls\spec;

use coveralls\JSONFile;
use coveralls\jsonfile\SourceFileCollection;

describe('JSONFile', function() {
    before(function() {
        $this->jsonFile = new JSONFile([
            'token' => 'foo',
            'sourceFiles' => new SourceFileCollection()
        ]);
    });
    describe('token', function() {
        it('should return repository token string', function() {
            expect($this->jsonFile->token)->toBe('foo');
        });
    });
    describe('sourceFiles', function() {
        it('should return sources file collection', function() {
            expect($this->jsonFile->sourceFiles)->toBeAnInstanceOf('coveralls\jsonfile\SourceFileCollection');
        });
    });
});
