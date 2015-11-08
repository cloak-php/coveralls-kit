<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace coverallskit;

/**
 * Interface Configuration
 */
interface Configuration
{
    /**
     * @param ReportBuilder $builder
     *
     * @return ReportBuilder
     */
    public function applyTo(ReportBuilder $builder);
}
