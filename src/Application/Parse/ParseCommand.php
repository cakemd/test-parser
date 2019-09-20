<?php

namespace CakeParser\Application\Parse;

use CakeParser\Application\Command\BaseCommand;
use CakeParser\Application\Console\ConsoleInputInterface;
use CakeParser\Application\Report\ReportSaver;
use CakeParser\Config\ConfigProvider;
use Psr\Http\Client\ClientInterface;

/**
 * Class ParseCommand
 * @package CakeParser\Application\Parse
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class ParseCommand extends BaseCommand
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;
    /**
     * @var ParseService
     */
    private $parseService;

    /**
     * @var ReportSaver
     */
    private $reportSaver;

    /**
     * @var string
     */
    private $url;

    /**
     * ParseCommand constructor.
     * @param ParseService $parseService
     * @param ReportSaver $reportSaver
     * @param ConfigProvider $configProvider
     */
    public function __construct(ParseService $parseService, ReportSaver $reportSaver, ConfigProvider $configProvider)
    {
        $this->parseService = $parseService;

        $this->reportSaver = $reportSaver;

        $this->configProvider = $configProvider;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'parse';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return "Retrieves images from given url and all its links and puts them to file";
    }

    /**
     * @param ConsoleInputInterface $consoleInput
     * @throws \CakeParser\Application\MissingRequiredParamException
     */
    public function applyInput(ConsoleInputInterface $consoleInput)
    {
        $this->url = $this->getRequiredParam($consoleInput, 'url', 0);
    }

    /**
     * @return callable
     */
    public function run() : callable
    {
        echo "started with {$this->url} \n";
        /** @var ParseServiceResult $parseServiceResult */
        $parseServiceResult = $this->parseService->parse($this->url, 2);

        $this->reportSaver->init('Page url', 'Image path');

        $parseServiceResult->each(function($url, $parentUrl, ParseResult $parseResult) {
            $this->reportSaver->add($url, $parseResult->getImgSrcList());
        });

        $saveResult = $this->reportSaver->save($this->url, $this->configProvider->getReportDirectory());

        if ($saveResult) {
            return function () use ($saveResult) {
                echo sprintf('%s%s', $this->configProvider->getReportUrlPath(), $saveResult->getFilename()) . PHP_EOL;
            };
        } else {
            return function () {
                echo "Cannot provide parse result" . PHP_EOL;
            };
        }

    }

}