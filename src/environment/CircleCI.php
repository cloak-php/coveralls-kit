<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\environment;

use coverallskit\Environment;


/**
 * Class CircleCI
 * @package coverallskit\environment
 */
final class CircleCI
{

    const CIRCLECI = 'CIRCLECI';


    /**
     * @var \coverallskit\Environment
     */
    private $environment;


    /**
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return bool
     */
    public function isSupported()
    {
        $value = $this->environment->get(self::CIRCLECI);
        return $value === 'true';
    }

}
