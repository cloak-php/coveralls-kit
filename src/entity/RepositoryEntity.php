<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace coverallskit\entity;

use coverallskit\CompositeEntity;

interface RepositoryEntity extends CompositeEntity
{
    /**
     * @return repository\Commit
     */
    public function getCommit();

    /**
     * @return repository\Branch
     */
    public function getBranch();

    /**
     * @return collection\RemoteCollection
     */
    public function getRemotes();
}
