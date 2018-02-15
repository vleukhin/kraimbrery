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
        $events = Event::all();

        return $this->twig->render($response, 'moderka/events/list.twig', [
            'events' => $events,
        ]);
    }
}