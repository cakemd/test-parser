<?php

namespace CakeParser\Application;


use CakeParser\Application\ApplicationInterface;
use CakeParser\Config\ConfigProvider;
use CakeParser\Application\WebApplication;

/**
 * Class AppInitiator
 * @package CakeParser\Application
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class AppInitiator
{
    /**
     * @return ApplicationInterface
     */
    public static function create(callable $configCallback = null)
    {
        $isCliApp = !isset($_SERVER['REQUEST_METHOD']);

        $configProvider = new ConfigProvider();

        if ($configCallback) {
            $configCallback($configProvider);
        }

        return $isCliApp
            ? new CliApplication($configProvider)
            : new WebApplication($configProvider);
    }
}