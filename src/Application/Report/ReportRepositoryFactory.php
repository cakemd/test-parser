<?php

namespace CakeParser\Application\Report;

use CakeParser\Application\FactoryInterface;
use CakeParser\Application\Url\Helper;
use CakeParser\Config\ConfigProvider;
use Psr\Container\ContainerInterface;

/**
 * Class ReportRepositoryFactory
 * @package CakeParser\Application\Report
 */
class ReportRepositoryFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param array|null $args
     * @return ReportRepository
     */
    public function create(ContainerInterface $container, array $args = null)
    {
        /** @var ConfigProvider $configProvider */
        $configProvider = $container->get('config_provider');
        $dirPath = $configProvider->getReportDirectory();

        /** @var Helper $urlHelper */
        $urlHelper = $container->get('url_helper');

        return new ReportRepository($dirPath, $urlHelper);
    }
}
