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

$app->any('/moderka', App\Controllers\Moderka::class .':MainAction');

$app->any('/moderka/afi[/{action}[/{id}]]', App\Controllers\Moderka::class .':AfiAction');
$app->post('/moderka/afiUpdate/{id}', App\Controllers\Moderka::class .':AfiUpdateAction');

$app->any('/moderka/img[/{type}[/{action}[/{file}]]]', App\Controllers\Moderka::class .':ImgAction');

$app->get('/moderka/news', App\Controllers\NewsController::class .':adminList');
$app->get('/moderka/news/create', App\Controllers\NewsController::class .':create');
$app->post('/moderka/news/create', App\Controllers\NewsController::class .':store');
$app->get('/moderka/news/{id}/edit', App\Controllers\NewsController::class .':edit');
$app->post('/moderka/news/{id}/update', App\Controllers\NewsController::class .':update');
$app->post('/moderka/news/{id}/delete', App\Controllers\NewsController::class .':delete');


$app->run();