<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tenants\Event;
use App\Models\Tenants\Flight;
use App\Http\Controllers\Controller;
use App\Services\Tenants\BookingService;
use App\Http\Requests\Tenants\StoreBookingRequest;

class BookingRequestController extends Controller
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
     * @param StoreBookingRequest $request
     * @param Event $slug
     * @param Flight $callsign
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookingRequest $request, Event $slug, Flight $callsign)
    {
        $this->bookingService->storeBookingRequest($request, $slug, $callsign);

        return redirect()->route('tenants.events.flights.index', ['slug' => $slug]);
    }
}
