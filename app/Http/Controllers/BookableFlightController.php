<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\BookableFlight;

class BookableFlightController extends Controller
{
    public function store(Request $request, Event $slug)
    {
        $bookableFlight = new BookableFlight([
            'event_id' => $slug->id,
            'data' => [
                'origin_airport_icao' => $request->input('origin_airport_icao'),
                'destination_airport_icao' => $request->input('destination_airport_icao'),
                'departure_time' => $request->input('departure_time'),
                'arrival_time' => $request->input('arrival_time'),
            ],
        ]);

        $bookableFlight->save();

        return redirect()->route('bookable.index', [
            'slug' => $slug,
        ]);
    }
}
