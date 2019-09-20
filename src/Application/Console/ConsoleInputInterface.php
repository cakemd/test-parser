<?php

namespace CakeParser\Application\Console;

/**
 * Interface ConsoleInputInterface
 * @package CakeParser\Application\Console
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
interface ConsoleInputInterface
{
    public function getCommand() : string;

    /**
     * @return string[]
     */
    public function getParams() : array;
}