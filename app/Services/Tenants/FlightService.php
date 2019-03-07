<?php

namespace App\Services\Tenants;

use App\Models\Tenants\Event;
use App\Models\Tenants\Flight;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Tenants\StoreFlight;
use App\Http\Requests\Tenants\UpdateFlight;

class FlightService
{
    /**
     * This is used during the index of flights.
     *
     * @param Event $event
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function indexOfficeFlight(Event $event)
    {
        return $event->flights()->paginate(config('extras.office.events.flights.per_page', 12));
    }

    /**
     * This is used during the creation of a new flight.
     *
     * @param StoreFlight $request
     * @return Flight
     */
    public function storeOfficeFlight(StoreFlight $request)
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

        Session::flash('success', 'The flight has been added successfully!');

        return $flight;
    }

    /**
     * This is used during the updating of a flight.
     *
     * @param UpdateFlight $request
     * @param Flight $flight
     * @return Flight
     */
    public function updateOfficeFlight(UpdateFlight $request, Flight $flight)
    {
        $flight->event_id = $request->event_id;
        $flight->pilot_id = $request->pilot_id;
        $flight->origin_airport_icao = $request->origin_airport_icao;
        $flight->destination_airport_icao = $request->destination_airport_icao;
        $flight->departure_time = $request->departure_time;
        $flight->arrival_time = $request->arrival_time;
        $flight->route = $request->route;
        $flight->aircraft_type_icao = $request->aircraft_type_icao;

        $flight->save();

        Session::flash('success', 'The flight has been updated successfully!');

        return $flight;
    }

    /**9
     * @param Flight $flight
     * @throws \Exception
     */
    public function destroyOfficeFlight(Flight $flight)
    {
        $this->delete($flight);

        Session::flash('success', 'The flight has been deleted successfully!');
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
     * @param Flight $flight
     * @throws \Exception
     */
    public function delete(Flight $flight)
    {
        $flight->delete();
    }
}
