<?php

declare(strict_types=1);

use app\controllers\SiteController;
use app\core\Application;
use app\core\ConfigParser;

require_once __DIR__ . '/../vendor/autoload.php';
(new ConfigParser(__DIR__ . '/../.env'))->load();

if (getenv('APP_ENV') === 'dev') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('log_errors', '1');
    ini_set('error_log', __DIR__ . '/../runtime/logFile.txt');
}

$app = new Application();

$app->router->setGetRoutes('/', [new SiteController(), 'presentation']);
$app->router->setPostRoutes('/handle', [new SiteController(), 'handlePresentation']);

ob_start();
$app->run();
ob_end_flush();