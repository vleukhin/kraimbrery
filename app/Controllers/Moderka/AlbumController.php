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
use Slim\Http\UploadedFile;

class AlbumController extends Controller
{
    protected $upload_dir = APP_ROOT . '/uploads/albums';

    public function adminList(Request $request, Response $response)
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

        $album->update([
            'name'        => $request->getParam('name'),
            'description' => $request->getParam('description'),
        ]);

        return $response->withRedirect('/moderka/albums/' . $album->id . '/edit');
    }

    public function addPhoto(Request $request, Response $response, array $args)
    {
        $album = Album::find($args['album'] ?? null);

        if (is_null($album)) {
            return $response->withStatus(404);
        }

        /** @var UploadedFile $photo */
        $photos = $request->getUploadedFiles()['photos'] ?? null;
        $album_photos = $album->photos;

        foreach ($photos as $photo){
            if ($photo and $photo->getError() === UPLOAD_ERR_OK) {
                $album_photos[] = moveUploadedFile($this->upload_dir, $photo);
            }
        }

        $album->photos = $album_photos;
        $album->save();

        return $response->withRedirect('/moderka/albums/' . $album->id . '/edit');
    }

    public function deletePhoto(Request $request, Response $response, array $args)
    {
        $album = Album::find($args['album'] ?? null);
        $index = $args['index'] ?? null;

        if (is_null($album) or is_null($index)) {
            return $response->withStatus(404);
        }

        $photos = $album->photos;
        $photo = $photos[$index];
        unset($photos[$index]);
        unlink($this->upload_dir . '/' . $photo);
        $album->photos = $photos;
        $album->save();

        return $response->withRedirect('/moderka/albums/' . $album->id . '/edit');
    }

    public function delete(Request $request, Response $response, array $args)
    {
        $album = Album::find($args['album'] ?? null);

        if (is_null($album)) {
            return $response->withStatus(404);
        }

        foreach ($album->photos as $photo) {
            unlink($this->upload_dir . '/' . $photo);
        }

        $album->delete();

        return $response->withRedirect('/moderka/albums');
    }

    public function show(Request $request, Response $response, $args)
    {
        $album = Album::find($args['id'] ?? null);

        if (is_null($album)) {
            return $response->withStatus(404);
        }

        return $this->twig->render($response, 'albums/show.twig', [
            'album' => $album,
        ]);
    }

    public function list(Request $request, Response $response)
    {
        $albums = Album::all();

        return $this->twig->render($response, 'albums/list.twig', [
            'albums' => $albums,
        ]);
    }
}