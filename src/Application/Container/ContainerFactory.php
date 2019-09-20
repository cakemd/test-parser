<?php

namespace CakeParser\Application\Container;


use CakeParser\Application\ApplicationInterface;
use CakeParser\Config\Source;
use Psr\Container\ContainerInterface;

/**
 * Class ContainerFactory
 * @package CakeParser\Application\Container
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class ContainerFactory
{
    /**
     * @return ContainerInterface
     */
    public static function create(ApplicationInterface $app) : ContainerInterface
    {
        $source = new Source();

        $source->init();

        $container = new Container($source);

        $source->add('container', $container);
        $source->add('config_provider', $app->getConfigProvider());

        return $container;
    }
}