<?php

namespace CakeParser\Application\Request;

/**
 * Class Request
 * @package CakeParser\Application\Request
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class Request
{
    public function getRequestUri()
    {
        return $_SERVER['REQUEST_URI'];
    }
}