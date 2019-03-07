<?php

namespace App\Http\Controllers\Tenants\Office;

use App\Models\Tenants\Event;
use App\Http\Controllers\Controller;
use App\Services\Tenants\EventService;
use App\Http\Requests\Tenants\StoreEvent;
use App\Http\Requests\Tenants\UpdateEvent;

class EventController extends Controller
{
    /** @var EventService */
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index()
    {
        $events = $this->eventService->getAll();

        return view('tenants.office.events.index', [
            'events' => $events,
        ]);
    }

    public function create()
    {
        return view('tenants.office.events.create');
    }

    public function store(StoreEvent $request)
    {
        $event = $this->eventService->storeEvent($request);

        return redirect()->route('tenants.office.events.show', $event);
    }

    public function show(Event $slug)
    {
        return view('tenants.office.events.show', [
            'event' => $slug,
        ]);
    }

    public function edit(Event $slug)
    {
        return view('tenants.office.events.edit', [
            'event' => $slug,
        ]);
    }

    public function update(UpdateEvent $request, Event $slug)
    {
        $event = $this->eventService->updateEvent($request, $slug);

        return redirect()->route('tenants.office.events.show', $event);
    }

    public function destroy(Event $slug)
    {
        $this->eventService->destroyEvent($slug);

        return redirect()->route('tenants.office.events.index');
    }
}
