<?php

namespace CakeParser\Application\Command;

/**
 * Class ErrorHandler
 * @package CakeParser\Application\Command
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class ErrorHandler implements ErrorHandlerInterface
{
    public function handle(\Throwable $e) : callable
    {
        return function () use ($e) {
            echo $e->getMessage() . "\n";
        };
    }
}