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
 * Interface ReportTransferAwareInterface
 * @package coverallskit
 */
interface ReportTransferAwareInterface
{

    /**
     * @param ReportTransferInterface $reportTransfer
     * @return $this
     */
    public function setReportTransfer(ReportTransferInterface $reportTransfer);

    /**
     * @return ReportTransferInterface
     */
    public function getReportTransfer();

}
