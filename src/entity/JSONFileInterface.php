<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coveralls\entity;

use coveralls\CompositeEntityInterface;

interface JSONFileInterface extends CompositeEntityInterface
{

    const DEFAULT_NAME = 'coverage.json';

    public function getName();

    public function saveAs($path);

    public function upload();

}
