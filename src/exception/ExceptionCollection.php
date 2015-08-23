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

use ArrayIterator;
use Countable;
use Exception;
use IteratorAggregate;

class ExceptionCollection extends Exception implements IteratorAggregate, Countable
{
    /**
     * @var ArrayIterator
     */
    private $exceptions;

    /**
     * @param string    $message
     * @param int       $code
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

        return $this;
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->exceptions->count();
    }

    public function isEmpty()
    {
        return $this->count() <= 0;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->exceptions->getArrayCopy());
    }

    public function merge(ExceptionCollection $exceptions)
    {
        foreach ($exceptions as $exception) {
            $this->add($exception);
        }

        return $this;
    }
}
