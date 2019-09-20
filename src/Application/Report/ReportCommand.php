<?php

namespace CakeParser\Application\Report;

use CakeParser\Application\Command\BaseCommand;
use CakeParser\Application\Console\ConsoleInputInterface;
use CakeParser\Application\Parse\ParseServiceInterface;

/**
 * Class ReportCommand
 * @package CakeParser\Application\Report
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class ReportCommand extends BaseCommand
{
    private $reportRepository;

    private $url;

    private $filepath;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "report";
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return "Shows report results in console";
    }

    /**
     * @param ConsoleInputInterface $consoleInput
     * @throws \CakeParser\Application\MissingRequiredParamException
     */
    public function applyInput(ConsoleInputInterface $consoleInput)
    {
        $url = $this->getRequiredParam($consoleInput, 'url', 0);

        $this->url = $url;

        $this->filepath = $this->reportRepository->findLastByUrl($url);
    }

    /**
     * @return callable
     */
    public function run(): callable
    {
        return function() {
            $result = [];
            if ($this->filepath) {
                $source = fopen($this->filepath, 'r');
                if ($source !== false) {
                    while (($data = fgetcsv($source, 1000, ',')) !== false) {
                        $result[] = $data;
                    }
                    fclose($source);
                }

                echo "Result for `{$this->url}`:" . PHP_EOL;
                foreach ($result as $row) {
                    list($linkColumn, $imgColumn) = $row;

                    $this->renderInColumns(100, $linkColumn, $imgColumn);
                }
            }
        };
    }
}
