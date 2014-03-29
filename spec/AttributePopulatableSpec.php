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

class AttributePopulatableObject
{
    use AttributePopulatable;

    protected $name = null;

    public function __get($name)
    {
        return $this->$name;
    }

}

describe('AttributePopulatable', function() {
    before(function() {
        $this->subject = new AttributePopulatableObject(); 
    });
    describe('populate', function() {
        before(function() {
            $this->subject->populate([
                'name' => 'foo'
            ]);
        });
        it('should populate object attributes', function() {
            expect($this->subject->name)->toEqual('foo');
        });
        context('when the specified attribute that does not exist', function() {
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
