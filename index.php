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

$app->get('/news-{id}-{url}', App\Controllers\Moderka\NewsController::class .':show');
$app->get('/news', App\Controllers\Moderka\NewsController::class .':list');

$app->any('/moderka', App\Controllers\Moderka::class .':MainAction');

//$app->any('/moderka/afi[/{action}[/{id}]]', App\Controllers\Moderka::class .':AfiAction');
//$app->post('/moderka/afiUpdate/{id}', App\Controllers\Moderka::class .':AfiUpdateAction');

$app->any('/moderka/img[/{type}[/{action}[/{file}]]]', App\Controllers\Moderka::class .':ImgAction');


$app->get('/moderka/events', App\Controllers\Moderka\EventsController::class .':list');
$app->post('/moderka/events/create', App\Controllers\Moderka\EventsController::class .':create');
$app->post('/moderka/events/{id}/update', App\Controllers\Moderka\EventsController::class .':update');

$app->get('/moderka/news', App\Controllers\Moderka\NewsController::class .':adminList');
$app->get('/moderka/news/create', App\Controllers\Moderka\NewsController::class .':create');
$app->post('/moderka/news/create', App\Controllers\Moderka\NewsController::class .':store');
$app->get('/moderka/news/{id}/edit', App\Controllers\Moderka\NewsController::class .':edit');
$app->post('/moderka/news/{id}/update', App\Controllers\Moderka\NewsController::class .':update');
$app->post('/moderka/news/{id}/delete', App\Controllers\Moderka\NewsController::class .':delete');


$app->run();