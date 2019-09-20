<?php

namespace CakeParser\Application\Parse;

/**
 * Interface ParserInterface
 * @package CakeParser\Application\Parse
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
interface ParserInterface
{
    public function parse($url) : ParseResult;
}