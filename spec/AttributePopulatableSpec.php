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
use Prophecy\Prophet;

class AttributePopulatableObject
{
    use AttributePopulatable;

    protected $name = null;
    protected $content = null;

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function __get($name)
    {
        return $this->$name;
    }

}

describe('AttributePopulatable', function() {
    before(function() {
        $this->prophet = new Prophet();
        $this->subject = new AttributePopulatableObject();
    });
    after(function() {
        $this->prophet->checkPredictions();
    });
    describe('populate', function() {
        context('', function() {
            before(function() {
                $subject = $this->prophet->prophesize('coverallskit\spec\AttributePopulatableObject');
                $subject->setContent('bar')->shouldBeCalled();

                $this->subject->populate([ 'content' => 'bar' ]);
            });
            it('should call the setter', function() {
                expect($this->subject->content)->toEqual('bar');
            });
        });
        context('when the specified attribute', function() {
            before(function() {
                $this->subject = new AttributePopulatableObject();
                $this->subject->populate([ 'name' => 'foo' ]);
            });
            it('should populate object attributes', function() {
                expect($this->subject->name)->toEqual('foo');
            });
        });
        context('when the specified attribute that does not exist', function() {
            before(function() {
                $this->subject = new AttributePopulatableObject();
            });
            it('should throw coverallskit\exception\BadAttributeException', function() {
                expect(function() {
                    $this->subject->populate([
                        'description' => 'foo'
                    ]);
                })->toThrow('coverallskit\exception\BadAttributeException');
            });
        });
    });
});
