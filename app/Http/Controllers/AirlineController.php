<?php

namespace App\Http\Controllers;

use App\Services\AirlineService;
use App\Http\Requests\StoreAirline;

class AirlineController extends Controller
{
    public function store(StoreAirline $request)
    {
        $airlineService = new AirlineService();
        $airlineService->processNewAirline($request);

        return redirect()->route('airlines.index');
    }
}
