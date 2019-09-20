<?php

namespace CakeParser\Application\Console;

use CakeParser\Application\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * Class ConsoleInputFactory
 * @package CakeParser\Application\Console
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class ConsoleInputFactory implements FactoryInterface
{
    private $command;

    private $commandArgs;

    public function create(ContainerInterface $container, array $argList = null)
    {
        /** @var string[] $args */
        $args = $_SERVER['argv'];

        $this->parseInput($args);

        return new ConsoleInput($this->command, $this->commandArgs);
    }

    private function parseInput(array $args)
    {
        //remove script name
        array_shift($args);

        $argsResult = [];

        $command = array_shift($args);

        if (!$command) {
            throw new \InvalidArgumentException("Command must be provided");
        }

        $this->command = $command;

        $skipByPrev = false;

        foreach ($args as $k => $arg) {
            $key = null;
            $value = null;
            $position = false;


            if ($skipByPrev) {
                $skipByPrev = false;
                continue;
            }

            $named2 = strpos($arg, '--') === 0;
            $named1 = !$named2 && strpos($arg, '-') === 0;

            if ($named1) {
                $skipByPrev = true;

                $key = substr($arg, 1);
                $potentialValue = $args[$k + 1];

                if (strpos($potentialValue, '=') !== 0) {
                    $value = $potentialValue;
                } else {
                    $value = true;
                }

            } elseif ($named2) {
                $argNoMinuses = substr($arg, 2);
                $eqSignPos = strpos($argNoMinuses , '=');

                if ($eqSignPos) {
                    $key = substr($argNoMinuses, 0, $eqSignPos);
                    $value = substr($argNoMinuses , $eqSignPos + 1);
                } else {
                    $key = $argNoMinuses;
                    $value = true;
                }
            } else {
                $key = count($argsResult);
                $value = $arg;
                $position = $k;
            }

            $argsResult[] = [$key, $value, $position];
        }

        $this->commandArgs = $argsResult;
    }
}