<?php

namespace CakeParser\Config;

/**
 * Class ConfigProvider
 * @package CakeParser\Config
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class ConfigProvider
{
    /**
     * @var string
     */
    private $reportsDir;

    /**
     * @var string
     */
    private $reportUrlPath;

    /**
     * @param string $reportsDir
     * @return bool
     */
    public function initReportDirectory(string $reportsDir)
    {
        $this->reportsDir = $reportsDir;
        return is_dir($reportsDir) || mkdir($reportsDir);
    }

    /**
     * @param $reportUrlPath
     */
    public function setReportUrlPath($reportUrlPath)
    {
        $this->reportUrlPath = $reportUrlPath;
    }

    /**
     * @return string
     */
    public function getReportDirectory()
    {
        return $this->reportsDir;
    }

    /**
     * @return mixed
     */
    public function getReportUrlPath()
    {
        return $this->reportUrlPath;
    }
}