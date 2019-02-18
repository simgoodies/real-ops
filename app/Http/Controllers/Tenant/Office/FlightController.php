<?php

namespace App\Http\Controllers\Tenant\Office;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenants\StoreFlight;
use App\Services\Tenants\EventService;
use App\Services\Tenants\FlightService;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    /**
     * @var FlightService
     */
    protected $flightService;

    /**
     * @var EventService
     */
    protected $eventService;

    public function __construct(FlightService $flightService, EventService $eventService)
    {
        $this->flightService = $flightService;
        $this->eventService = $eventService;
    }


    public function store(StoreFlight $request)
    {
        $flight = $this->flightService->storeFlight($request);
        $event = $this->eventService->getById($flight->event_id);
        return redirect()->route('tenants.office.events.flights.index', $event);
    }
}
