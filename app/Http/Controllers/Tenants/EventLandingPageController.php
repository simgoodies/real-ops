<?php

namespace App\Http\Controllers\Tenants;

use App\Models\Tenants\Event;
use App\Http\Controllers\Controller;
use App\Services\Tenants\EventService;

class EventLandingPageController extends Controller
{
    /**
     * @var EventService
     */
    protected $eventService;
    
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function show(Event $slug)
    {
        $viewData = $this->eventService->showEventLandingPage($slug);

        return view('tenants.events.show')->with(['event' => $viewData['event'], 'flights' => $viewData['flights']]);
    }
}
