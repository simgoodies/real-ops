<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEvent;
use App\Http\Requests\UpdateEvent;
use App\Services\Tenants\EventService;
use Illuminate\Http\Request;

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
            'events' => $events
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

    public function show($slug)
    {
        $event = $this->eventService->getBySlug($slug);
        abort_if(is_null($event),404);

        return view('tenants.office.events.show', [
            'event' => $event
        ]);
    }

    public function edit($slug)
    {
        $event = $this->eventService->getBySlug($slug);
        abort_if(is_null($event),404);

        return view('tenants.office.events.edit', [
            'event' => $event
        ]);
    }

    public function update(UpdateEvent $request, $slug)
    {
        $event = $this->eventService->getBySlug($slug);
        abort_if(is_null($event),404);

        $event = $this->eventService->updateEvent($request, $slug);

        return redirect()->route('tenants.office.events.show', $event);
    }

    public function destroy(Request $request, $slug)
    {
        $event = $this->eventService->getBySlug($slug);
        abort_if(is_null($event),404);

        $this->eventService->destroyEvent($request, $slug);

        return redirect()->route('tenants.office.events.index');
    }
}
