<?php
/**
 * Created by Viktor Leukhin.
 * Tel: +7-926-797-5419
 * E-mail: vleukhin@ya.ru
 */

namespace App\Controllers\Moderka;

use App\Models\News;
use Slim\Http\Request;
use Slim\Http\Response;

class NewsController extends Controller
{
    protected $upload_dir = APP_ROOT . '/uploads/news';

    public function adminList(Request $request, Response $response)
    {
        $news = News::orderBy('weight', 'desc')->get();

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

        $news->url = urlencode(translit($news->title));
        $news->weight = News::max('weight') + 1;

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

        $news->url = urlencode(translit($news->title));

        $uploadedFiles = $request->getUploadedFiles();

        // handle single input with single file upload
        $uploadedFile = $uploadedFiles['image'] ?? null;

        if ($uploadedFile and $uploadedFile->getError() === UPLOAD_ERR_OK) {
            $news->image = moveUploadedFile($this->upload_dir, $uploadedFile);
        }

        $news->save();

        return $response->withRedirect('/moderka/news');
    }

    public function sort(Request $request, Response $response)
    {
        $order = $request->getParsedBody()['order'] ?? [];
        $count = count($order);

        foreach ($order as $id){
            News::where('id', $id)->update(['weight' => $count]);
            $count--;
        }

        return $response;
    }

    public function delete(Request $request, Response $response, $args)
    {
        $news = News::find($args['id']);

        if (!$news){
            return $response->withStatus(404);
        }

        $news->delete();

        if ($news->image){
            unlink($this->upload_dir . '/' . $news->image);
        }

        return $response->withRedirect('/moderka/news');
    }

    public function show(Request $request, Response $response, $args)
    {
        $news = News::find($args['id']);

        if (!$news) {
            return $response->withStatus(404);
        }

        return $this->twig->render($response, 'news/show.twig', [
            'news' => $news,
        ]);
    }

    public function list(Request $request, Response $response)
    {
        return $this->twig->render($response, 'news/list.twig', [
            'list' => News::orderBy('weight', 'desc')->get()
        ]);
    }
}