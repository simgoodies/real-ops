<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAirline;
use App\Services\AirlineService;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    public function store(StoreAirline $request)
    {
        $airlineService = new AirlineService();
        $airlineService->processNewAirline($request);

        return redirect()->route('airlines.index');
    }
}
