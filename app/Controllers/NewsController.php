<?php
/**
 * Created by Viktor Leukhin.
 * Tel: +7-926-797-5419
 * E-mail: vleukhin@ya.ru
 */

namespace App\Controllers;


use Slim\Http\Request;
use Slim\Http\Response;

class NewsController
{
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function adminList(Request $request, Response $response)
    {
        return $this->container['view']->render($response, 'moderka/news/list.twig');
    }
}