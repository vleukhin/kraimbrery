<?php
/**
 * Created by Viktor Leukhin.
 * Tel: +7-926-797-5419
 * E-mail: vsleuhin@ya.ru
 */

namespace App\Controllers\Moderka;


use App\Models\Album;
use Slim\Http\Request;
use Slim\Http\Response;

class AlbumController extends Controller
{
    public function list(Request $request, Response $response)
    {
        $albums = Album::all();

        return $this->twig->render($response, 'moderka/albums/list.twig', [
            'albums' => $albums,
        ]);
    }

    public function create(Request $request, Response $response)
    {
        $name = $request->getParam('name');

        $album = Album::create([
            'name'   => $name,
            'url'    => urlencode(translit($name)),
            'photos' => [],
        ]);

        return $response->withRedirect('/moderka/albums/' . $album->id . '/edit');
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $album = Album::find($args['album'] ?? null);

        if (is_null($album)) {
            return $response->withStatus(404);
        }

        return $this->twig->render($response, 'moderka/albums/edit.twig', [
            'album' => $album,
        ]);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $album = Album::find($args['album'] ?? null);

        if (is_null($album)) {
            return $response->withStatus(404);
        }

        $name = $request->getParam('name');

        $album->update([
            'name' => $name,
        ]);

        return $response->withRedirect('/moderka/albums/' . $album->id . '/edit');
    }
}