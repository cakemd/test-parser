<?php

namespace CakeParser\Application\Action;

use CakeParser\Application\Request\Request;

/**
 * Interface ActionInterface
 * @package CakeParser\Application\Action
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
interface ActionInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param Request $request
     * @return void
     */
    public function applyRequest(Request $request);

    /**
     * @return callable
     */
    public function run() : callable;
}