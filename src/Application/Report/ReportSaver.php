<?php

namespace CakeParser\Application\Report;

use CakeParser\Application\Url\Helper;

/**
 * Class ReportSaver
 * @package CakeParser\Application\Report
 */
class ReportSaver
{
    private $urlHelper;

    private $rows;

    public function __construct(Helper $helper)
    {
        $this->urlHelper = $helper;
    }

    /**
     * @param string[] ...$headers
     */
    public function init(...$headers)
    {
        $this->rows[] = $headers;
    }

    /**
     * @param string   $url
     * @param string[] $imgList
     */
    public function add($url, $imgList)
    {
        $this->rows[] = [$url, null];

        foreach ($imgList as $img) {
            $this->rows[] = [null, $img];
        }
    }

    /**
     * @param $path
     * @return ReportSaveResult
     */
    public function save($url, $path)
    {
        $result = $this->urlHelper->parseUrl($url);

        if (!$result->isValid()) {
            return false;
        }

        $host = $result->getHost();

        $dirPath = sprintf('%s/%s', $path, $host);

        if (!is_dir($dirPath)) {
            mkdir($dirPath);
        }

        $now = new \DateTime();

        $filename = sprintf('%s-%s.csv', $now->format('YmdHis'), uniqid('result'));
        $fullpath = sprintf('%s/%s', $dirPath, $filename);
        $source = fopen($fullpath, 'w');

        foreach ($this->rows as $row) {
            fputcsv($source, $row);
        }

        fclose($source);

        return new ReportSaveResult($filename, $fullpath);
    }
}