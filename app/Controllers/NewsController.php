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

    protected $upload_dir = APP_ROOT . '/uploads/news';

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

    public function create(Request $request, Response $response)
    {
        return $this->twig->render($response, 'moderka/news/create.twig');
    }

    public function store(Request $request, Response $response)
    {
        $news = new News($request->getParsedBody());

        $news->url = translit($news->title);

        $uploadedFiles = $request->getUploadedFiles();

        // handle single input with single file upload
        $uploadedFile = $uploadedFiles['image'] ?? null;

        if ($uploadedFile and $uploadedFile->getError() === UPLOAD_ERR_OK) {
            $news->image = moveUploadedFile($this->upload_dir, $uploadedFile);
        }

        $news->save();

        return $response->withRedirect('/moderka/news');
    }

    public function edit(Request $request, Response $response, $args)
    {
        $news = News::find($args['id']);

        if (!$news){
           return $response->withStatus(404);
        }

        return $this->twig->render($response, 'moderka/news/edit.twig', [
            'news' => $news,
        ]);
    }

    public function update(Request $request, Response $response, $args)
    {
        $news = News::find($args['id']);

        if (!$news){
            return $response->withStatus(404);
        }

        $news->fill($request->getParsedBody());

        $news->url = translit($news->title);

        $uploadedFiles = $request->getUploadedFiles();

        // handle single input with single file upload
        $uploadedFile = $uploadedFiles['image'] ?? null;

        if ($uploadedFile and $uploadedFile->getError() === UPLOAD_ERR_OK) {
            $news->image = moveUploadedFile($this->upload_dir, $uploadedFile);
        }

        $news->save();

        return $response->withRedirect('/moderka/news');
    }
}