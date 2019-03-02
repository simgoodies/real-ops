<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenants\StoreBooking;
use App\Models\Tenants\Event;
use App\Models\Tenants\Flight;
use App\Services\Tenants\BookingService;

class BookingController extends Controller
{
    /**
     * @var BookingService
     */
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBooking $request, Event $slug, Flight $callsign)
    {
        $this->bookingService->storeBooking($request, $callsign);

        return redirect()->route('tenants.events.flights.show', ['slug' => $slug, 'callsign' => $callsign]);
    }
}
