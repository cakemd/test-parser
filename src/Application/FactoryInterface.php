<?php

namespace CakeParser\Application;

use Psr\Container\ContainerInterface;

interface FactoryInterface
{
    public function create(ContainerInterface $container, array $args = null);
}