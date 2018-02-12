<?php
require_once './vendor/autoload.php';

define('APP_ROOT', __DIR__);

$dotenv = new Dotenv\Dotenv('./');
$dotenv->load();

$config = require './config/app.php';

$app = new \Slim\App(['settings' => $config]);

$container = $app->getContainer();

require './app/lib/dependencies.php';

$app->add(new \Slim\Middleware\HttpBasicAuthentication([
    'path'  => '/moderka',
    'realm' => 'Protected',
    'secure' => false,
    'users' => [
        getenv('ADMIN_NAME') => getenv('ADMIN_PASS'),
    ],
]));

$app->get('/', App\Controllers\Landing::class .':MainAction');

$app->get('/moderka', App\Controllers\Moderka::class .':MainAction');
$app->any('/moderka/afi[/{action}[/{id}]]', App\Controllers\Moderka::class .':AfiAction');
$app->post('/moderka/afiUpdate/{id}', App\Controllers\Moderka::class .':AfiUpdateAction');
//$app->get('/', App\Controllers\Landing::class .':MainAction');

$app->run();