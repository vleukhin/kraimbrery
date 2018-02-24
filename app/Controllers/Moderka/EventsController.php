<?php

namespace App\Controllers\Moderka;

use App\Models\Event;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Created by Viktor Leukhin.
 * Tel: +7-926-797-5419
 * E-mail: vleukhin@ya.ru
 */
class EventsController extends Controller
{
    public function list(Request $request, Response $response)
    {
        $events = Event::select()->orderBy('weight');

        return $this->twig->render($response, 'moderka/events/list.twig', [
            'events' => $events->get()->toArray(),
        ]);
    }

    public function create(Request $request, Response $response)
    {
        $event = new Event($request->getParsedBody());

        $event->weight = (Event::max('weight') ?? 0) + 1;
        $event->save();

        return $response->withRedirect('/moderka/events');
    }

    public function update(Request $request, Response $response, $args)
    {
        $event = Event::find($args['id'] ?? null);

        if (is_null($event)){
            return $response->withStatus(404);
        }

        $event->update($request->getParsedBody());

        return $response->withRedirect('/moderka/events');
    }

    public function delete(Request $request, Response $response, $args)
    {
        $event = Event::find($args['id'] ?? null);

        if (is_null($event)){
            return $response->withStatus(404);
        }

        $event->delete();

        return $response->withRedirect('/moderka/events');
    }

    public function sort(Request $request, Response $response)
    {
        $order = $request->getParsedBody()['order'] ?? [];

        foreach ($order as $weight => $id){
            Event::where('id', $id)->update(['weight' => $weight]);
        }

        return $response;
    }

    public function import()
    {
        $afi_list = include(dirname(__FILE__) . '/../../afi.php');

        foreach ($afi_list['list'] ?? [] as $afi) {
            if (!Event::where('title', $afi['city'])->count()) {
                Event::create([
                    'title'  => $afi['city'],
                    'date'   => $afi['date'],
                    'link'   => $afi['link'],
                    'weight' => (Event::max('weight') ?? 0) + 1,
                ]);
            }
        }
    }
}