<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvent;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return view('office.events.index');
    }

    public function create()
    {
        return view('office.events.create');
    }

    public function store(StoreEvent $request)
    {
        $eventService = new EventService();
        $event = $eventService->processNewEvent($request);

        return redirect()->route('events.show', $event);
    }

    public function show($slug)
    {

    }
}
