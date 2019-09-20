<?php

namespace CakeParser\Application\Command;

use CakeParser\Application\Console\ConsoleInputInterface;

/**
 * Interface CommandInterface
 * @package CakeParser\Application\Command
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
interface CommandInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getDescription(): string ;

    /**
     * @param ConsoleInputInterface $consoleInput
     * @return mixed
     */
    public function applyInput(ConsoleInputInterface $consoleInput);

    /**
     * @return callable
     */
    public function run() : callable;
}