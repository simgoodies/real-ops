<?php

namespace App\Http\Controllers\Tenants\Bookings;

use Illuminate\Http\Request;
use App\Models\Tenants\Event;
use App\Models\Tenants\Pilot;
use App\Models\Tenants\Flight;
use App\Http\Controllers\Controller;
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
     * @param Request $request
     * @param Event $slug
     * @param Flight $callsign
     * @param Pilot $vatsimId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Event $slug, Flight $callsign, Pilot $vatsimId)
    {
        $this->bookingService->storeBooking($request, $slug, $callsign, $vatsimId);

        return redirect()->route('tenants.events.flights.show', ['slug' => $slug, 'callsign' => $callsign]);
    }

    /**
     * @param Request $request
     * @param Event $slug
     * @param Flight $callsign
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Event $slug, Flight $callsign)
    {
        $this->bookingService->destroyBooking($request, $slug, $callsign);

        return redirect()->route('tenants.events.flights.show', ['slug' => $slug, 'callsign' => $callsign]);
    }
}
