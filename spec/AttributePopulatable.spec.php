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

use coverallskit\AttributePopulatable;
use coverallskit\exception\BadAttributeException;
use Prophecy\Prophet;

class AttributePopulatableObject
{
    use AttributePopulatable;

    protected $name = null;
    protected $content = null;
    protected $setterCalled = false;

    public function __construct(array $values)
    {
        $this->populate($values);
    }

    public function setContent($content)
    {
        $this->content = $content;
        $this->setterCalled = true;
    }

    public function __get($name)
    {
        return $this->$name;
    }

}

describe('AttributePopulatable', function() {
    describe('populate', function() {
        context('when the specified attribute', function() {
            beforeEach(function() {
                $this->subject = new AttributePopulatableObject([ 'name' => 'foo', 'content' => 'bar' ]);
            });
            it('should populate object attributes', function() {
                expect($this->subject->name)->toEqual('foo');
            });
            it('should call the setter', function() {
                expect($this->subject->content)->toEqual('bar');
                expect($this->subject->setterCalled)->toBeTrue();
            });
        });
        context('when the specified attribute that does not exist', function() {
            it('should throw coverallskit\exception\BadAttributeException', function() {
                expect(function() {
                    new AttributePopulatableObject([ 'description' => 'foo' ]);
                })->toThrow(BadAttributeException::class);
            });
        });
    });
});
