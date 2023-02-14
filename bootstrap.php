<?php 

use Slim\Factory\AppFactory;

require_once __DIR__.'/vendor/autoload.php';

$app = AppFactory::create();

require_once __DIR__.'/router/Api.php';

$app->run();