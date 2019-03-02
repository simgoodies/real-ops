<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenants\Event;
use App\Models\Tenants\Flight;

class FlightController extends Controller
{
    public function show(Event $slug, Flight $callsign)
    {
        return 'yo';
    }
}
