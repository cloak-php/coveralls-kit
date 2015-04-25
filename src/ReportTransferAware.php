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
 * Interface ReportTransferAware
 * @package coverallskit
 */
interface ReportTransferAware
{

    /**
     * @param ReportTransfer $reportTransfer
     * @return $this
     */
    public function setReportTransfer(ReportTransfer $reportTransfer);

    /**
     * @return ReportTransfer
     */
    public function getReportTransfer();

}
