<?php

require_once __DIR__ . '/vendor/autoload.php';

use CakeParser\Application;
use CakeParser\Config\ConfigProvider;

$reportsDir = __DIR__ . '/reports';

/**
 * @var Application\ApplicationInterface $app
 */
$app = Application\AppInitiator::create(function (ConfigProvider $configProvider) use ($reportsDir) {
    $configProvider->initReportDirectory($reportsDir);
    $configProvider->setDomain('http://localhost:8000');
    $configProvider->setReportUriPath('/reports/');
});

$app->run()
    ->send();
