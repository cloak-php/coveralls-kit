<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\exception;

use Exception;
use Iterator;
use ArrayIterator;
use Countable;

class ExceptionCollection extends Exception implements Iterator, Countable
{

    /**
     * @var ArrayIterator
     */
    private $exceptions;

    public function __construct($message = '', $code = 0, Exception $previous = null)
    {
        $this->exceptions = new ArrayIterator();
        parent::__construct($message, $code, $previous);
    }

    public function add(Exception $exception)
    {
        $this->exceptions->append($exception);
    }

    public function current()
    {
        return $this->exceptions->current();
    }

    public function key()
    {
        return $this->exceptions->key();
    }

    public function next()
    {
        $this->exceptions->next();
    }

    public function rewind()
    {
        $this->exceptions->rewind();
    }

    public function valid()
    {
        return $this->exceptions->valid();
    }

    public function count()
    {
        return $this->exceptions->count();
    }

}
