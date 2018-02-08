<?php
session_start();
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('APP_ROOT', __DIR__ . '/..');

require_once dirname(__FILE__).'/../vendor/autoload.php';

use App\Controllers as Controllers;

$routes = array(
    '/moderka/img/:any/:any' => 'Moderka/ImgAction/$1/$2',
    '/moderka/:any/:any/:any' => 'Moderka/$1Action/$2/$3',
    '/moderka/:any/:any' => 'Moderka/$1Action/$2',
    '/moderka/:any' => 'Moderka/$1Action',
    '/moderka' => 'Moderka/MainAction',
    '/:any' => 'Error/E404Action',
);
Controllers\Router::addRoute($routes);
Controllers\Router::dispatch();