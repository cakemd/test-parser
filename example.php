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
    $configProvider->setReportUrlPath('http://localhost:8000/');
});

$app->run()
    ->send();
