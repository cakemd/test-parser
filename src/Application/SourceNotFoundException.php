<?php

namespace CakeParser\Application;

use Psr\Container\ContainerExceptionInterface;
use Throwable;

/**
 * Class SourceNotFoundException
 * @package CakeParser\Application
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class SourceNotFoundException extends \Exception implements ContainerExceptionInterface
{
    /**
     * SourceNotFoundException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        $id = $message;

        $message = sprintf('Unable to find \'%s\'', $id);

        parent::__construct($message, $code, $previous);
    }
}