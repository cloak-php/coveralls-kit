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
 * Class AbstractAdaptor
 * @package coverallskit\environment
 */
abstract class AbstractAdaptor implements EnvironmentAdaptor
{

    /**
     * @var \coverallskit\Environment
     */
    protected $environment;


    /**
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * {@inheritdoc}
     */
    public function getCoverallsToken()
    {
        return $this->environment->get(self::COVERALLS_REPO_TOKEN);
    }

}
