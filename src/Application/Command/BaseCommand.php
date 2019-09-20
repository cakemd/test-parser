<?php

namespace CakeParser\Application\Command;


use CakeParser\Application\Console\ConsoleInputInterface;
use CakeParser\Application\MissingRequiredParamException;

/**
 * Class BaseCommand
 * @package CakeParser\Application\Command
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
abstract class BaseCommand implements CommandInterface
{
    /**
     * @param ConsoleInputInterface $consoleInput
     * @param string $paramName
     * @param int|null $position
     * @return mixed
     * @throws MissingRequiredParamException
     */
    protected function getRequiredParam(ConsoleInputInterface $consoleInput, string $paramName, int $position = null)
    {
        return $this->getParam(true, $consoleInput, $paramName, $position);
    }

    /**
     * @param ConsoleInputInterface $consoleInput
     * @param string $paramName
     * @param int|null $position
     * @return mixed
     * @throws MissingRequiredParamException
     */
    protected function getOptionalParam(ConsoleInputInterface $consoleInput, string $paramName, int $position = null)
    {
        return $this->getParam(false, $consoleInput, $paramName, $position);
    }

    /**
     * @param $fire404
     * @param ConsoleInputInterface $consoleInput
     * @param string $paramName
     * @param int|null $position
     * @return mixed
     * @throws MissingRequiredParamException
     */
    private function getParam($fire404, ConsoleInputInterface $consoleInput, string $paramName, int $position = null)
    {
        $inputParams = $consoleInput->getParams();

        foreach ($inputParams as $inputParam) {
            list($inputName, $inputValue, $inputPosition) = $inputParam;
            if ($inputName === $paramName) {
                return $inputValue;
            }

            if (!is_null($position) && $inputPosition === $position) {
                return $inputValue;
            }
        }

        if ($fire404) {
            throw new MissingRequiredParamException(sprintf('Required param %s not found', $paramName));
        }
    }

    /**
     * @param int $columnWidth
     * @param mixed ...$cols
     */
    protected function renderInColumns(int $columnWidth, ...$cols)
    {
        while (count($cols)) {
            $col = array_shift($cols);
            echo $col;
            if (count($cols)) {
                $colLength = strlen($col);
                $spaces = $colLength >= $columnWidth
                    ? 0
                    : ($columnWidth - $colLength);

                echo str_repeat(" ", $spaces);
            }
        }
        echo PHP_EOL;
    }
}
