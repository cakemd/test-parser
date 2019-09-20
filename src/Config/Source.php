<?php

namespace CakeParser\Config;

use CakeParser\Application\Action\ActionProvider;
use CakeParser\Application\Command\CommandProvider;
use CakeParser\Application\Command\CommandProviderInterface;
use CakeParser\Application\Command\ErrorHandler;
use CakeParser\Application\Console\ConsoleInputFactory;
use CakeParser\Application\Console\ConsoleInputInterface;
use CakeParser\Application\Command\ErrorHandlerInterface;
use CakeParser\Application\Help\HelpCommand;
use CakeParser\Application\Parse\ParseCommand;
use CakeParser\Application\Parse\Parser;
use CakeParser\Application\Parse\ParserInterface;
use CakeParser\Application\Parse\ParseService;
use CakeParser\Application\Parse\ParseServiceInterface;
use CakeParser\Application\Report\ReportCommand;
use CakeParser\Application\Report\ReportDownloadAction;
use CakeParser\Application\Report\ReportRepository;
use CakeParser\Application\Report\ReportRepositoryFactory;
use CakeParser\Application\Report\ReportSaver;
use CakeParser\Application\Request\Request;
use CakeParser\Application\Url\Helper;

/**
 * Class Source
 * @package CakeParser\Config
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class Source
{
    /**
     * @var array
     */
    private $config;

    /**
     * Builds config
     */
    public function init()
    {
        $config = [];

        $config[] = array(
            'id' => ErrorHandlerInterface::class,
            'class' => ErrorHandler::class
        );

        $config[] = array(
            'id' => ConsoleInputInterface::class,
            'factory' => ConsoleInputFactory::class
        );

        $config[] = array(
            'id' => ConsoleInputFactory::class,
            'class' => ConsoleInputFactory::class
        );

        $config[] = array(
            'id' => CommandProviderInterface::class,
            'class' => CommandProvider::class,
            'argIdList' => 'container'
        );

        $config[] = array(
            'id' => 'parse_command',
            'class' => ParseCommand::class,
            'argIdList' => [
                ParseServiceInterface::class,
                ReportSaver::class,
                'config_provider'
            ],
            'tags' => ['command']
        );

        $config[] = array(
            'id' => ParserInterface::class,
            'class' => Parser::class,
            'argIdList' => [
            ]
        );

        $config[] = array(
            'id' => ReportSaver::class,
            'class' => ReportSaver::class,
            'argIdList' => ['url_helper']
        );

        $config[] = array(
            'id' => ParseServiceInterface::class,
            'class' => ParseService::class,
            'argIdList' => [
                ParserInterface::class
            ],
        );

        $config[] = array(
            'id' => HelpCommand::class,
            'class' => HelpCommand::class,
            'argIdList' => [
                CommandProviderInterface::class
            ],
            'tags' => ['command']
        );

        $config[] = array(
            'id' => ReportCommand::class,
            'class' => ReportCommand::class,
            'argIdList' => [
                ReportRepository::class
            ],
            'tags' => ['command']
        );

        $config[] = array(
            'id' => ReportRepository::class,
            'factory' => ReportRepositoryFactory::class
        );

        $config[] = array(
            'id' => 'url_helper',
            'class' => Helper::class
        );

        $config[] = array(
            'id' => ReportRepositoryFactory::class,
            'class' => ReportRepositoryFactory::class,
            'argIdList' => [
                'config_provider',
            ],
        );

        $config[] = array(
            'id' => ActionProvider::class,
            'class' => ActionProvider::class,
            'argIdList' => [
                'container',
            ],
        );

        $config[] = array(
            'id' => Request::class,
            'class' => Request::class,
        );

        $config[] = array(
            'id' => ReportDownloadAction::class,
            'class' => ReportDownloadAction::class,
            'argIdList' => [
                ReportRepository::class
            ],
            'tags' => ['action']
        );

        $this->config = $config;
    }

    /**
     * @param string $id
     * @param string|object $class
     * @param array|null $argIdList
     * @param string|null $factory
     * @param array|null $tags
     */
    public function add(
        string $id,
        $class,
        $argIdList = null,
        $factory = null,
        $tags = null
    ) {
        $this->config[] = array(
            'id' => $id,
            'class' => $class,
            'argIdList' => $argIdList,
            'factory' => $factory,
            'tags' => $tags
        );
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->config;
    }
}