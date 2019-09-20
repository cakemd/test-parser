<?php

namespace CakeParser\Application\Report;

use CakeParser\Application\Url\Helper;

/**
 * Class ReportRepository
 * @package CakeParser\Application\Report
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class ReportRepository
{
    private $dirPath;

    private $helper;

    public function __construct(string $dirPath, Helper $helper)
    {
        $this->dirPath = $dirPath;

        $this->helper = $helper;
    }

    /**
     * @param string $url
     * @return bool|null|string
     */
    public function findLastByUrl(string $url)
    {
        $parsedUrl = $this->helper->parseUrl($url);

        if (!$parsedUrl->isValid()) {
            return null;
        }

        $hostDirList = $this->getHostDirList($parsedUrl->getHost());

        $found = null;
        $foundDir = null;

        foreach ($hostDirList as $hostDir) {
            $content = scandir($hostDir, SCANDIR_SORT_DESCENDING);

            if (count($content) <= 2) {
                continue;
            }

            //get date part in dormat YmdHis
            $lastInDir = substr($content[0], 0, 14);

            if (!$found || $lastInDir > $found) {
                $found = $lastInDir;
                $foundPath = sprintf('%s/%s', $hostDir, $content[0]);
            }
        }

        return $foundPath ?: false;
    }

    /**
     * @param $name
     * @return string|bool
     */
    public function findByName($name)
    {
        foreach (scandir($this->dirPath) as $item) {
            if ($item !== '.' && $item !== '..') {

                $itemFull = sprintf('%s/%s', $this->dirPath, $item);

                $reports = scandir($itemFull);

                foreach ($reports as $report) {
                    if ($report === $name) {

                        $fullPath = sprintf('%s/%s', $itemFull, $report);

                        return is_file($fullPath) ? $fullPath : false;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @param $host
     * @return string[]
     */
    private function getHostDirList($host)
    {
        $hostReverse = strrev($host);
        $dirList = scandir($this->dirPath);
        $hostDirList = [];

        foreach ($dirList as $item) {
            $isDir = $item !== '.' && $item !== '..' && is_dir($this->dirPath . '/' . $item);

            if (!$isDir) {
                continue;
            }

            $reversed = strrev($item);
            $isDomainDir = strpos($reversed, $hostReverse) === 0;

            if ($isDomainDir) {
                $hostDirList[] = sprintf('%s/%s', $this->dirPath, $item);
            }
        }

        return $hostDirList;
    }
}