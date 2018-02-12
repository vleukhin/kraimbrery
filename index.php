<?php
require_once './vendor/autoload.php';

define('APP_ROOT', __DIR__);

$dotenv = new Dotenv\Dotenv('./');
$dotenv->load();

$config = require './config/app.php';

$app = new \Slim\App(['settings' => $config]);

$container = $app->getContainer();

require './app/lib/dependencies.php';

$app->get('/', App\Controllers\Landing::class .':MainAction');

$app->run();