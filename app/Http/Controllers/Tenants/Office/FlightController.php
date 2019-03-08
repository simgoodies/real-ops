<?php

namespace App\Http\Controllers\Tenants\Office;

use App\Models\Tenants\Event;
use App\Models\Tenants\Flight;
use App\Http\Controllers\Controller;
use App\Services\Tenants\FlightService;
use App\Http\Requests\Tenants\StoreFlight;
use App\Http\Requests\Tenants\UpdateFlight;

class FlightController extends Controller
{
    /**
     * @var FlightService
     */
    protected $flightService;

    public function __construct(FlightService $flightService)
    {
        $this->flightService = $flightService;
    }

    public function index(Event $slug)
    {
        $flights = $this->flightService->indexOfficeFlight($slug);

        return view('tenants.office.events.flights.index', [
            'event' => $slug,
            'flights' => $flights,
        ]);
    }

    public function edit(Event $slug, Flight $callsign)
    {
        return view('tenants.office.events.flights.edit', [
            'event' => $slug,
            'flight' => $callsign,
        ]);
    }

    public function update(UpdateFlight $request, Event $slug, Flight $callsign)
    {
        $this->flightService->updateOfficeFlight($request, $callsign);
        
        return redirect()->route('tenants.office.events.flights.index', $slug);
    }

    public function store(StoreFlight $request, Event $slug)
    {
        $this->flightService->storeOfficeFlight($request);
        
        return redirect()->route('tenants.office.events.flights.index', $slug);
    }

    public function destroy(Event $slug, Flight $callsign)
    {
        $this->flightService->destroyOfficeFlight($callsign);
        
        return redirect()->route('tenants.office.events.flights.index', $slug);
    }
}
