<?php

namespace CakeParser\Application\Parse;

/**
 * Interface ParseServiceInterface
 * @package CakeParser\Application\Parse
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
interface ParseServiceInterface
{
    public function parse($url, int $subLevels = null);
}