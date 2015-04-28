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

use ReflectionMethod;
use UnexpectedValueException;
use SplFileObject;


/**
 * Class RecordLexer
 * @package coverallskit\report\lcov
 */
class RecordLexer
{

    /**
     * @var SplFileObject
     */
    private $reportFile;

    /**
     * @var array
     */
    private $recordTypes = [
        SourceFile::class,
        Coverage::class,
        EndOfRecord::class
    ];

    /**
     * @param string $reportPath
     */
    public function __construct($reportPath)
    {
        $this->reportFile = new SplFileObject($reportPath, 'r');
        $this->reportFile->setFlags(
            SplFileObject::DROP_NEW_LINE |
            SplFileObject::SKIP_EMPTY
        );
    }

    /**
     * @return \Generator
     */
    public function records()
    {
        while ($this->reportFile->eof() === false) {
            $record = $this->reportFile->fgets();

            try {
                $lcovRecord = $this->detectRecord($record);
                yield $lcovRecord;
            } catch (UnexpectedValueException $e) {
                continue;
            }
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
