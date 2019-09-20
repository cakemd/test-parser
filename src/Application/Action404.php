<?php

namespace CakeParser\Application;

use CakeParser\Application\Action\BaseAction;
use CakeParser\Application\Request\Request;

/**
 * Class Action404
 * @package CakeParser\Application
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class Action404 extends BaseAction
{
    /**
     * @return string
     */
    public function getId()
    {
        return '404';
    }

    /**
     * @param Request $request
     */
    public function applyRequest(Request $request)
    {

    }

    /**
     * @return callable
     */
    public function run(): callable
    {
        return function() {
            echo '<DOCTYPE html>';
            echo '<html>';
                echo '<head>';
                    echo '<title>Not found</title>';
                echo '</head>';
                echo '<body>';
                    echo '<h1>404</h1>';
                echo '</body>';
            echo '</html>';
        };
    }
}