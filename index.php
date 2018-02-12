<?php
require './vendor/autoload.php';

$dotenv = new Dotenv\Dotenv('./');
$dotenv->load();

define('APP_ROOT', __DIR__);

require_once dirname(__FILE__).'/vendor/autoload.php';

use App\Controllers as Controllers;

$routes = array(
    '/' => 'Landing/MainAction',
    '/:any' => 'Error/E404Action',
);
Controllers\Router::addRoute($routes);
Controllers\Router::dispatch();