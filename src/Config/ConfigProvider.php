<?php

namespace CakeParser\Config;

/**
 * Class ConfigProvider
 * @package CakeParser\Config
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class ConfigProvider
{
    private $domain;

    /**
     * @var string
     */
    private $reportsDir;

    /**
     * @var string
     */
    private $reportUriPath;

    /**
     * @param string $reportsDir
     * @return bool
     */
    public function initReportDirectory(string $reportsDir)
    {
        $this->reportsDir = $reportsDir;
        return is_dir($reportsDir) || mkdir($reportsDir);
    }

    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @param $reportUrlPath
     */
    public function setReportUriPath($reportUrlPath)
    {
        $this->reportUriPath = $reportUrlPath;
    }

    /**
     * @return string
     */
    public function getReportUriPath()
    {
        return $this->reportUriPath;
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
    public function getFullReportUriPath()
    {
        return $this->domain . $this->reportUriPath;
    }
}