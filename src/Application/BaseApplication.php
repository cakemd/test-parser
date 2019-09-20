<?php

namespace CakeParser\Application;

use CakeParser\Application\Container\ContainerFactory;
use CakeParser\Config\ConfigProvider;
use Psr\Container\ContainerInterface;

abstract class BaseApplication implements ApplicationInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ConfigProvider
     */
    private $configProvider;


    public function __construct(ConfigProvider $configProvider)
    {
        $this->configProvider = $configProvider;
    }

    public function getConfigProvider(): ConfigProvider
    {
        return $this->configProvider;
    }

    protected function initContainer()
    {
        $this->container = ContainerFactory::create($this);
    }
}