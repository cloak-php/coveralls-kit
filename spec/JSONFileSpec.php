<?php

namespace coveralls\spec;

use coveralls\JSONFile;
use PhpCollection\Sequence;

describe('JSONFile', function() {
    before(function() {
        $this->jsonFile = new JSONFile([
            'repositoryToken' => 'foo',
            'sourceFiles' => new Sequence()
        ]);
    });
    describe('repositoryToken', function() {
        it('should return repository token string', function() {
            expect($this->jsonFile->repositoryToken)->toBe('foo');
        });
    });
    describe('sourceFiles', function() {
        it('should return sources file collection', function() {
            expect($this->jsonFile->sourceFiles)->toBeAnInstanceOf('PhpCollection\Sequence');
        });
    });
});
