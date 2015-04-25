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
 * Trait ReportTransferAwareTrait
 * @package coverallskit
 */
trait ReportTransferAwareTrait
{

    /**
     * @var ReportTransfer
     */
    protected $reportTransfer;

    /**
     * {@inheritdoc}
     */
    public function setReportTransfer(ReportTransfer $reportTransfer)
    {
        $this->reportTransfer = $reportTransfer;
        return $this;
    }

    /**
     * @return ReportTransfer
     */
    public function getReportTransfer()
    {
        $reportTransfer = $this->reportTransfer;
        $reportTransfer = (is_null($reportTransfer)) ? new CoverallsReportTransfer() : $reportTransfer;
        $this->reportTransfer = $reportTransfer;

        return $this->reportTransfer;
    }

}
