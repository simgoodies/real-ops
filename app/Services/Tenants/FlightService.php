<?php

namespace App\Services\Tenants;

use App\Models\Tenants\Event;
use App\Models\Tenants\Flight;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Tenants\Office\StoreFlight;
use App\Http\Requests\Tenants\Office\UpdateFlight;

class FlightService
{
    protected $airportService;
    
    public function __construct(AirportService $airportService)
    {
        $this->airportService = $airportService;
    }

    /**
     * This is used during the index of flights.
     *
     * @param Event $event
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function indexOfficeFlight(Event $event)
    {
        return $event->flights()
            ->orderBy('departure_time')
            ->orderBy('callsign')
            ->with(['originAirport', 'destinationAirport'])
            ->paginate(config('extras.office.events.flights.per_page', 12));
    }

    /**
     * This is used during the creation of a new flight.
     *
     * @param StoreFlight $request
     * @return Flight
     */
    public function storeOfficeFlight(StoreFlight $request)
    {
        $originAirportId = $this->airportService->getByIcao($request->origin_airport_icao)->id;
        $destinationAirportId = $this->airportService->getByIcao($request->destination_airport_icao)->id;
            
        $flight = new Flight();
        $flight->event_id = $request->event_id;
        $flight->pilot_id = $request->pilot_id;
        $flight->callsign = $request->callsign;
        $flight->origin_airport_id = $originAirportId;
        $flight->destination_airport_id = $destinationAirportId;
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
        $originAirportId = $this->airportService->getByIcao($request->origin_airport_icao)->id;
        $destinationAirportId = $this->airportService->getByIcao($request->destination_airport_icao)->id;
        
        $flight->event_id = $request->event_id;
        $flight->pilot_id = $request->pilot_id;
        $flight->origin_airport_id = $originAirportId;
        $flight->destination_airport_id = $destinationAirportId;
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
     * Method that will display flighs for given event for event landing page.
     *
     * @param Event $event
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllForEventLandingPage(Event $event)
    {
        return $event->flights()
            ->orderBy('departure_time')
            ->orderBy('callsign')
            ->get();
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
