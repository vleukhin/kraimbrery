<?php
/**
 * Created by Viktor Leukhin.
 * Tel: +7-926-797-5419
 * E-mail: vleukhin@ya.ru
 */

namespace App\Controllers;


use App\Models\News;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class NewsController
{
    /**
     * @var Twig
     */
    protected $twig;

    public function __construct($container)
    {
        $this->container = $container;
        $this->twig = $container['view'];
    }

    public function adminList(Request $request, Response $response)
    {
        $news = News::all();

        return $this->twig->render($response, 'moderka/news/list.twig', [
            'news' => $news,
        ]);
    }
}