<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tenants\Event;
use App\Models\Tenants\Flight;
use App\Http\Controllers\Controller;

class FlightController extends Controller
{
    public function index(Event $slug)
    {
        return 'index';
    }

    public function show(Event $slug, Flight $callsign)
    {
        return 'show';
    }
}
