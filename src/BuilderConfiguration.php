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

use coverallskit\entity\Repository;
use coverallskit\exception\FileNotFoundException;
use coverallskit\exception\NotSupportFileTypeException;
use coverallskit\configuration\Basic;
use coverallskit\configuration\Report;
use Zend\Config\Config;
use Yosymfony\Toml\Toml;
use Eloquent\Pathogen\Factory\PathFactory;


/**
 * Class BuilderConfiguration
 * @package coverallskit
 */
class BuilderConfiguration implements RootConfiguration
{

    /**
     * @var configuration\Basic
     */
    private $basic;

    /**
     * @var configuration\Report
     */
    private $report;

    /**
     * @var \Eloquent\Pathogen\PathInterface
     */
    private $directoryPath;


    /**
     * @param Config $config
     */
    public function __construct(Config $config = null)
    {
        $userConfig = $config ? $config : new Config([]);

        $current = $this->getDefaultConfigration();
        $current->merge($userConfig);

        $directoryPath = $current->get(self::CONFIG_DIRECTORY_KEY, getcwd());
        $this->directoryPath = PathFactory::instance()->create($directoryPath);

        $this->basic = new Basic($current, $this->directoryPath);

        $reportFile = $current->get(Report::REPORT_FILE_KEY);
        $this->report = new Report($reportFile, $this->directoryPath);
    }

    /**
     * @return string
     */
    public function getReportFileName()
    {
        return $this->report->getReportFileName();
    }

    /**
     * @return string
     */
    public function getCoverageReportFileType()
    {
        return $this->report->getCoverageReportFileType();
    }

    /**
     * @return string
     */
    public function getCoverageReportFilePath()
    {
        return $this->report->getCoverageReportFilePath();
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->basic->getToken();
    }

    /**
     * @return \coverallskit\entity\ServiceEntity
     */
    public function getService()
    {
        return $this->basic->getService();
    }

    /**
     * @return \coverallskit\entity\RepositoryEntity
     */
    public function getRepository()
    {
        return $this->basic->getRepository();
    }

    /**
     * @param ReportBuilder $builder
     * @return ReportBuilder
     */
    public function applyTo(ReportBuilder $builder)
    {
        $this->basic->applyTo($builder);
        $this->report->applyTo($builder);

        return $builder;
    }

    /**
     * @return Config
     */
    protected function getDefaultConfigration()
    {

        $config = new Config([
            Basic::TOKEN_KEY => null,
            Basic::SERVICE_KEY => null,
            Report::REPORT_FILE_KEY => [
                Report::OUTPUT_REPORT_FILE_KEY => 'coveralls.json'
            ],
            Basic::REPOSITORY_DIRECTORY_KEY => '.'
        ]);

        return $config;
    }

    /**
     * @param string $file
     * @return BuilderConfiguration
     * @throws \coverallskit\exception\NotSupportFileTypeException
     * @throws \coverallskit\exception\FileNotFoundException
     */
    public static function loadFromFile($file)
    {
        if (file_exists($file) === false) {
            throw new FileNotFoundException($file);
        }

        if (preg_match('/(\.toml)$/', $file) !== 1) {
            throw new NotSupportFileTypeException($file);
        }

        $values = Toml::parse($file);
        $values = (is_array($values) === true) ? $values : [];

        $config = new Config($values);
        $config->merge(new Config([
            self::CONFIG_FILE_KEY => $file,
            self::CONFIG_DIRECTORY_KEY => dirname(realpath($file)) . DIRECTORY_SEPARATOR
        ]));

        return new BuilderConfiguration($config);
    }

}
