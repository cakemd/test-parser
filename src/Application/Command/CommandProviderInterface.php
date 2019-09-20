<?php

namespace CakeParser\Application\Command;

use CakeParser\Application\Console\ConsoleInputInterface;

/**
 * Interface CommandProviderInterface
 * @package CakeParser\Application\Command
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
interface CommandProviderInterface
{
    /**
     * @param ConsoleInputInterface $consoleInput
     * @return CommandInterface
     * @throws CommandNotFoundInterface
     */
    public function findCommand(ConsoleInputInterface $consoleInput) : CommandInterface;

    /**
     * @return CommandInterface[]
     */
    public function findAll() : array;
}