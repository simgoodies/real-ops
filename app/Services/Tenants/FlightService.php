<?php

namespace App\Services\Tenants;

use App\Http\Requests\Tenants\StoreFlight;
use App\Http\Requests\Tenants\UpdateFlight;
use App\Models\Tenants\Event;
use App\Models\Tenants\Flight;

class FlightService
{
    /**
     * @var EventService
     */
    protected $eventService;

    public function __construct()
    {
        $this->eventService = new EventService();
    }

    /**
     * @param Event $event
     * @return mixed
     */
    public function getAllForEvent(Event $event)
    {
        return $event->flights->all();
    }

    /**
     * This is used during the creation of a new flight.
     *
     * @param StoreFlight $request
     * @return Flight
     */
    public function storeFlight(StoreFlight $request)
    {
        $flight = new Flight();
        $flight->event_id = $request->event_id;
        $flight->pilot_id = $request->pilot_id;
        $flight->callsign = $request->callsign;
        $flight->origin_airport_icao = $request->origin_airport_icao;
        $flight->destination_airport_icao = $request->destination_airport_icao;
        $flight->departure_time = $request->departure_time;
        $flight->arrival_time = $request->arrival_time;
        $flight->route = $request->route;
        $flight->aircraft_type_icao = $request->aircraft_type_icao;

        $flight->save();

        return $flight;
    }

    /**9
     * @param Flight $flight
     * @throws \Exception
     */
    public function destroyFlight(Flight $flight)
    {
        $this->delete($flight);
    }

    /**
     * @param Flight $flight
     * @throws \Exception
     */
    public function delete(Flight $flight)
    {
        $flight->delete();
    }

    public function updateFlight(UpdateFlight $request, Flight $flight)
    {
        $flight->event_id = $request->event_id;
        $flight->pilot_id = $request->pilot_id;
        $flight->callsign = $request->callsign;
        $flight->origin_airport_icao = $request->origin_airport_icao;
        $flight->destination_airport_icao = $request->destination_airport_icao;
        $flight->departure_time = $request->departure_time;
        $flight->arrival_time = $request->arrival_time;
        $flight->route = $request->route;
        $flight->aircraft_type_icao = $request->aircraft_type_icao;

        $flight->save();

        return $flight;
    }
}
