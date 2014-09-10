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

    /**
     * @param string $message
     * @param int $code
     * @param Exception $previous
     */
    public function __construct($message = '', $code = 0, Exception $previous = null)
    {
        $this->exceptions = new ArrayIterator([]);
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param Exception $exception
     */
    public function add(Exception $exception)
    {
        $this->exceptions->append($exception);
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->exceptions->current();
    }

    /**
     * @return mixed
     */
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

    /**
     * @return bool
     */
    public function valid()
    {
        return $this->exceptions->valid();
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->exceptions->count();
    }

}
