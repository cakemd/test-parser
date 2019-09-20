<?php

namespace CakeParser\Application\Command;

use CakeParser\Application\Console\ConsoleInputInterface;
use Psr\Container\ContainerInterface;

/**
 * Class CommandProvider
 * @package CakeParser\Application\Command
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class CommandProvider implements CommandProviderInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param ConsoleInputInterface $consoleInput
     * @return CommandInterface
     * @throws CommandNotFoundException
     */
    public function findCommand(ConsoleInputInterface $consoleInput): CommandInterface
    {
        /** @var CommandInterface[] $commands */
        $commands = $this->container->get('command');

        foreach ($commands as $command) {

            if (!$command instanceof CommandInterface) {
                continue;
            }

            if ($command->getName() === $consoleInput->getCommand()) {
                $command->applyInput($consoleInput);
                return $command;
            }
        }

        throw new CommandNotFoundException($consoleInput->getCommand());
    }

    /**
     * @return CommandInterface[]
     */
    public function findAll(): array
    {
        return $this->container->get('command');
    }
}