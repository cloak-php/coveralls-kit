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
use coverallskit\configuration\Base;
use coverallskit\configuration\Report;
use Zend\Config\Config;
use Symfony\Component\Yaml\Yaml;
use Eloquent\Pathogen\Factory\PathFactory;


/**
 * Class Configuration
 * @package coverallskit
 */
class Configuration implements RootConfigurationInterface
{

    /**
     * @var configuration\Base
     */
    private $base;

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

        $this->base = new Base($current, $this->directoryPath);

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
        return $this->base->getToken();
    }

    /**
     * @return \coverallskit\entity\service\ServiceInterface
     */
    public function getService()
    {
        return $this->base->getService();
    }

    /**
     * @return entity\Repository
     */
    public function getRepository()
    {
        return $this->base->getRepository();
    }

    /**
     * @param ReportBuilderInterface $builder
     * @return ReportBuilderInterface
     */
    public function applyTo(ReportBuilderInterface $builder)
    {
        $this->base->applyTo($builder);
        $this->report->applyTo($builder);

        return $builder;
    }

    /**
     * @return Config
     */
    protected function getDefaultConfigration()
    {

        $config = new Config([
            Base::TOKEN_KEY => null,
            Base::SERVICE_KEY => 'travis-ci',
            Report::REPORT_FILE_KEY => [
                Report::OUTPUT_REPORT_FILE_KEY => 'coveralls.json'
            ],
            Base::REPOSITORY_DIRECTORY_KEY => '.'
        ]);

        return $config;
    }

    /**
     * @param string $file
     * @return Configuration
     * @throws \coverallskit\exception\NotSupportFileTypeException
     * @throws \coverallskit\exception\FileNotFoundException
     */
    public static function loadFromFile($file)
    {
        if (file_exists($file) === false) {
            throw new FileNotFoundException($file);
        }

        if (preg_match('/(\.yml|yaml)$/', $file) !== 1) {
            throw new NotSupportFileTypeException($file);
        }

        $values = Yaml::parse($file);
        $values = (is_array($values) === true) ? $values : [];

        $config = new Config($values);
        $config->merge(new Config([
            self::CONFIG_FILE_KEY => $file,
            self::CONFIG_DIRECTORY_KEY => dirname(realpath($file)) . DIRECTORY_SEPARATOR
        ]));

        return new Configuration($config);
    }

}
