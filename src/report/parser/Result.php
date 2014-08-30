<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\report\parser;

use coverallskit\entity\collection\SourceFileCollection;

/**
 * Class Result
 * @package coverallskit\report\parser
 */
class Result
{

    /**
     * @var \coverallskit\entity\collection\SourceFileCollection
     */
    private $sources;

    /**
     * @var array
     */
    private $parseErrors;

    /**
     * @param SourceFileCollection $sources
     */
    public function __construct(SourceFileCollection $sources, array $parseErrors)
    {
        $this->sources = $sources;
        $this->parseErrors = $parseErrors;
    }

    /**
     * @return SourceFileCollection
     */
    public function getSources()
    {
        return $this->sources;
    }

}
