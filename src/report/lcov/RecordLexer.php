<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\report\lcov;

use IteratorAggregate;
use ReflectionMethod;
use ArrayIterator;
use UnexpectedValueException;


/**
 * Class RecordLexer
 * @package coverallskit\report\lcov
 */
class RecordLexer implements IteratorAggregate
{

    /**
     * @var array
     */
    private $records;

    /**
     * @var array
     */
    private $recordTypes = [
        SourceFile::class,
        Coverage::class,
        EndOfRecord::class
    ];


    /**
     * @param string $reportContent
     */
    public function __construct($reportContent)
    {
        $this->parse($reportContent);
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->records);
    }

    /**
     * @param string $reportContent
     */
    private function parse($reportContent)
    {
        $records = explode(PHP_EOL, $reportContent);

        foreach ($records as $record) {
            try {
                $result = $this->detectRecord($record);
            } catch (UnexpectedValueException $e) {
                continue;
            }
            $this->records[] = $result;
        }
    }

    /**
     * @param string $record
     * @return \coverallskit\report\lcov\FileRecord
     * @throws \UnexpectedValueException
     */
    private function detectRecord($record)
    {
        foreach ($this->recordTypes as $recordType) {
            $method = new ReflectionMethod($recordType, 'match');
            $arguments = [$record];

            if ($method->invokeArgs(null, $arguments) === false) {
                continue;
            }

            $class = $method->getDeclaringClass();

            return ($class->hasMethod('__construct'))
                ? $class->newInstanceArgs($arguments) : $class->newInstance();
        }

        throw new UnexpectedValueException();
    }

}
