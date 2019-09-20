<?php

namespace CakeParser\Application\Console;

/**
 * Class ConsoleInput
 * @package CakeParser\Application\Console
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class ConsoleInput implements ConsoleInputInterface
{
    /**
     * @var string
     */
    private $command;

    /**
     * @var array
     */
    private $args;

    /**
     * ConsoleInput constructor.
     * @param string $command
     * @param array $args
     */
    public function __construct(string $command, array $args)
    {
        $this->command = $command;
        $this->args = $args;
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->args;
    }
}
