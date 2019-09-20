<?php

namespace CakeParser\Application\Report;


use CakeParser\Application\Action\BaseAction;
use CakeParser\Application\Request\Request;
use CakeParser\Config\ConfigProvider;

/**
 * Class ReportDownloadAction
 * @package CakeParser\Application\Report
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class ReportDownloadAction extends BaseAction
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var ReportRepository
     */
    private $reportRepository;

    /**
     * @var string
     */
    private $uri;

    public function __construct(ReportRepository $reportRepository, ConfigProvider $configProvider)
    {
        $this->configProvider = $configProvider;

        $this->reportRepository = $reportRepository;
    }

    public function getId()
    {
        return 'reports';
    }

    public function applyRequest(Request $request)
    {
        $this->uri = $request->getRequestUri();
    }

    public function run(): callable
    {
        //get rid from route prefix
        $name = substr($this->uri, strlen($this->configProvider->getReportUriPath()));

        $report = $this->reportRepository->findByName($name);

        if ($report) {

            return function () use ($report) {
                header('Content-Type: text/csv');

                header('Content-Disposition: attachment; filename="report.csv"');

                readfile($report);
            };
        } else {
            return function() {
                echo '<DOCTYPE html>';
                echo '<html>';
                echo '<head>';
                echo '<title>Report not found</title>';
                echo '</head>';
                echo '<body>';
                echo '<h1>Report not found</h1>';
                echo '</body>';
                echo '</html>';
            };
        }
    }
}