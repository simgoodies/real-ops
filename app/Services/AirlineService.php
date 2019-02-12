<?php

namespace App\Services;

use App\Models\Airline;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AirlineService
{
    /**
     * Do all required actions to successfully process a new airline.
     *
     * @param Request $request
     * @return Event
     */
    public function processNewAirline(Request $request)
    {
        $airline = new Airline();
        $airline->name = $request->name;
        $airline->callsign = Str::upper($request->callsign);
        $airline->icao = Str::upper($request->icao);

        $airline->save();

        return $airline;
    }
}
