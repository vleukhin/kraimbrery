<?php

define('APP_ROOT', __DIR__ . '/');

require_once APP_ROOT . 'vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(APP_ROOT);
$dotenv->load();

$config = require APP_ROOT. 'config/app.php';

$app = new \Slim\App(['settings' => $config]);

$container = $app->getContainer();

require APP_ROOT. 'app/lib/dependencies.php';

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

$app->get('/album-{id}-{url}', App\Controllers\Moderka\AlbumController::class .':show');
$app->get('/albums', App\Controllers\Moderka\AlbumController::class .':list');

$app->any('/moderka', App\Controllers\Moderka::class .':MainAction');

$app->any('/moderka/img[/{type}[/{action}[/{file}]]]', App\Controllers\Moderka::class .':ImgAction');

$app->post('/moderka/settings/remove-video-cover', App\Controllers\Moderka::class .':removeVideoCover');


$app->get('/moderka/events', App\Controllers\Moderka\EventsController::class .':list');
$app->post('/moderka/events/create', App\Controllers\Moderka\EventsController::class .':create');
$app->post('/moderka/events/{id}/update', App\Controllers\Moderka\EventsController::class .':update');
$app->get('/moderka/events/{id}/delete', App\Controllers\Moderka\EventsController::class .':delete');
$app->post('/moderka/events/sort', App\Controllers\Moderka\EventsController::class .':sort');
$app->get('/events/import', App\Controllers\Moderka\EventsController::class .':import');

$app->get('/moderka/news', App\Controllers\Moderka\NewsController::class .':adminList');
$app->get('/moderka/news/create', App\Controllers\Moderka\NewsController::class .':create');
$app->post('/moderka/news/create', App\Controllers\Moderka\NewsController::class .':store');
$app->get('/moderka/news/{id}/edit', App\Controllers\Moderka\NewsController::class .':edit');
$app->post('/moderka/news/{id}/update', App\Controllers\Moderka\NewsController::class .':update');
$app->post('/moderka/news/{id}/delete', App\Controllers\Moderka\NewsController::class .':delete');
$app->post('/moderka/news/sort', App\Controllers\Moderka\NewsController::class .':sort');

$app->get('/moderka/albums', App\Controllers\Moderka\AlbumController::class .':adminList');
$app->post('/moderka/albums/create', App\Controllers\Moderka\AlbumController::class .':create');
$app->get('/moderka/albums/{album}/edit', App\Controllers\Moderka\AlbumController::class .':edit');
$app->post('/moderka/albums/{album}/edit', App\Controllers\Moderka\AlbumController::class .':update');
$app->post('/moderka/albums/{album}/delete', App\Controllers\Moderka\AlbumController::class .':delete');
$app->post('/moderka/album/{album}/add-photo', App\Controllers\Moderka\AlbumController::class .':addPhoto');
$app->get('/moderka/albums/{album}/delete-photo/{index}', App\Controllers\Moderka\AlbumController::class .':deletePhoto');
$app->post('/moderka/albums/{album}/sort', App\Controllers\Moderka\AlbumController::class .':sort');

$app->run();