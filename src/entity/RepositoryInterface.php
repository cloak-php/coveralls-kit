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

interface RepositoryInterface extends CompositeEntityInterface
{

    /**
     * @return coveralls\entity\repository\Commit
     */
    public function getCommit();

    /**
     * @return coveralls\entity\repository\Branch
     */
    public function getBranch();

    /**
     * @return coveralls\entity\collection\RemoteCollection;
     */
    public function getRemotes();

}
