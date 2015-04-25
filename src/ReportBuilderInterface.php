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

use coverallskit\entity\SourceFile;
use coverallskit\entity\collection\SourceFileCollection;
use coverallskit\entity\RepositoryEntity;
use coverallskit\entity\ServiceEntity;


/**
 * Interface ReportBuilderInterface
 * @package coverallskit
 */
interface ReportBuilderInterface
{

    /**
     * @param string $reportFilePath
     * @return ReportBuilderInterface
     */
    public function reportFilePath($reportFilePath);

    /**
     * @param string
     * @return ReportBuilderInterface;
     */
    public function token($repositoryToken);

    /**
     * @param ServiceEntity
     * @return ReportBuilderInterface
     */
    public function service(ServiceEntity $service);

    /**
     * @param RepositoryEntity
     * @return ReportBuilderInterface
     */
    public function repository(RepositoryEntity $repository);

    /**
     * @param SourceFile $source
     * @return ReportBuilderInterface
     */
    public function addSource(SourceFile $source);

    /**
     * @param SourceFileCollection $sources
     * @return ReportBuilderInterface
     */
    public function addSources(SourceFileCollection $sources);

    /**
     * @return \coverallskit\entity\ReportEntity
     */
    public function build();

}
