<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEvent;
use App\Http\Requests\UpdateEvent;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $eventService = new EventService();
        $events = $eventService->getAll();

        return view('office.events.index')
            ->with('events', $events);
    }

    public function create()
    {
        return view('office.events.create');
    }

    public function store(StoreEvent $request)
    {
        $eventService = new EventService();
        $event = $eventService->processNewEvent($request);

        return redirect()->route('office.events.show', $event);
    }

    public function show($slug)
    {
        $eventService = new EventService();
        $event = $eventService->getBySlug($slug);
        return view('office.events.show')
            ->with('event', $event);
    }

    public function edit($slug)
    {
        $eventService = new EventService();
        $event = $eventService->getBySlug($slug);
        return view('office.events.edit')
            ->with('event', $event);
    }

    public function update(UpdateEvent $request, $slug)
    {
        $eventService = new EventService();
        $event = $eventService->patchEvent($request, $slug);

        return redirect()->route('office.events.show', $event);
    }
}
