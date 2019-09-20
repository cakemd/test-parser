<?php

namespace CakeParser\Application\Command;

/**
 * Interface ErrorHandlerInterface
 * @package CakeParser\Application\Command
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
interface ErrorHandlerInterface
{
    public function handle(\Throwable $e) : callable ;
}