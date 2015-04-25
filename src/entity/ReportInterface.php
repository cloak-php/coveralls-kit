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
use coverallskit\ReportTransferAwareInterface;

/**
 * Interface ReportInterface
 * @package coverallskit\entity
 */
interface ReportInterface extends CompositeEntity, ReportTransferAwareInterface
{

    const DEFAULT_NAME = 'coverage.json';

    /**
     * @return string
     */
    public function getName();

    /**
     * @return $this
     */
    public function save();

    /**
     * @param string $path
     * @return $this
     */
    public function saveAs($path);

    /**
     * @return void
     */
    public function upload();

}
