<?php
session_start();
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once dirname(__FILE__).'/vendor/autoload.php';

use App\Controllers as Controllers;

$routes = array(
    '/' => 'Landing/MainAction',
    '/:any' => 'Error/E404Action',
);
Controllers\Router::addRoute($routes);
Controllers\Router::dispatch();