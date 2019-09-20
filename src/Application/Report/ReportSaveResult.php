<?php

namespace CakeParser\Application\Report;

/**
 * Class ReportSaveResult
 * @package CakeParser\Application\Report
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class ReportSaveResult
{
    private $filename;

    private $fullPath;

    public function __construct(string $filename, string $fullPath)
    {
        $this->filename = $filename;

        $this->fullPath = $fullPath;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function getFullPath()
    {
        return $this->fullPath;
    }
}