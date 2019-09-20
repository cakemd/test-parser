<?php
/**
 * Created by PhpStorm.
 * User: mrcake
 * Date: 9/15/19
 * Time: 6:17 PM
 */

namespace CakeParser\Application;


use CakeParser\Config\ConfigProvider;

interface ApplicationInterface
{
    public function getConfigProvider() : ConfigProvider;

    public function run() : self;

    public function send();
}