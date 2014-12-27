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



/**
 * Class TravisPro
 * @package coverallskit\environment
 */
final class TravisPro extends Travis implements AdaptorInterface
{

    const NAME = 'travis-pro';


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }

}
