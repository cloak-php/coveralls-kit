<?php

namespace coveralls\spec;

use coveralls\jsonfile\SourceFile;
use coveralls\jsonfile\SourceFileCollection;

describe('SourceFileCollection', function() {
    before(function() {
        $this->path = __DIR__ . '/fixtures/foo.php';
        $this->source = [
            'name' => $this->path,
            'source' => file_get_contents($this->path),
            'coverage' => [null,null,null,null]
        ];
        $this->values = [ $this->source ];

        $this->sources = new SourceFileCollection();
        $this->sources->add(new SourceFile($this->path));
    });
    describe('toArray', function() {
        it('should return array value', function() {
            expect($this->sources->toArray())->toEqual($this->values);
        });
    });
    describe('__toString', function() {
        it('should return json string', function() {
            expect((string) $this->sources)->toEqual(json_encode($this->values));
        });
    });
});
