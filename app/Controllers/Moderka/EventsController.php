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
}