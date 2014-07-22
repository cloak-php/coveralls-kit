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

use coverallskit\entity\RepositoryInterface;
use coverallskit\entity\service\ServiceInterface;

/**
 * Interface ReportBuilderInterface
 * @package coverallskit
 */
interface ReportBuilderInterface
{

    /**
     * @param string
     * @return $this;
     */
    public function name($name);

    /**
     * @param string
     * @return $this;
     */
    public function token($repositoryToken);

    /**
     * @param ServiceInterface
     * @return $this;
     */
    public function service(ServiceInterface $service);

    /**
     * @param RepositoryInterface
     * @return $this;
     */
    public function repository(RepositoryInterface $repository);

    /**
     * @return \coverallskit\entity\ReportInterface
     */
    public function build();

}
