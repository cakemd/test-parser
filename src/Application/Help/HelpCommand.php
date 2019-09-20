<?php

namespace CakeParser\Application\Help;

use CakeParser\Application\Command\BaseCommand;
use CakeParser\Application\Command\CommandInterface;
use CakeParser\Application\Command\CommandNotFoundException;
use CakeParser\Application\Command\CommandProviderInterface;
use CakeParser\Application\Console\ConsoleInputInterface;

/**
 * Class HelpCommand
 * @package CakeParser\Application\Help
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class HelpCommand extends BaseCommand
{
    private $commandProvider;

    private $targetCommand;

    /**
     * HelpCommand constructor.
     * @param CommandProviderInterface $commandProvider
     */
    public function __construct(CommandProviderInterface $commandProvider)
    {
        $this->commandProvider = $commandProvider;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'help';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Shows this message';
    }

    /**
     * @param ConsoleInputInterface $consoleInput
     * @throws \CakeParser\Application\MissingRequiredParamException
     */
    public function applyInput(ConsoleInputInterface $consoleInput)
    {
        $this->targetCommand = $this->getOptionalParam($consoleInput, 'command', 0);
    }

    public function run(): callable
    {
        return function () {
            /** @var CommandInterfac[] $commands */
            $commands = [];
            $showAll  = !$this->targetCommand;

            if ($this->targetCommand) {
                try {
                    $commands[] = $this->commandProvider->findCommand($this->targetCommand);
                } catch (CommandNotFoundException $e) {
                    $showAll = true;
                }
            }

            if ($showAll) {
                $commands = $this->commandProvider->findAll();
            }

            foreach ($commands as $command) {
                $this->renderInColumns(30, $command->getName(), $command->getDescription());
            }
        };
    }

}