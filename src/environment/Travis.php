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
 * Class Travis
 * @package coverallskit\environment
 */
final class Travis implements AdaptorInterface
{

    const NAME = 'travis';
    const TRAVIS = 'TRAVIS';


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
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * @return bool
     */
    public function isSupported()
    {
        $value = $this->environment->get(self::TRAVIS);
        return $value === 'true';
    }

}
