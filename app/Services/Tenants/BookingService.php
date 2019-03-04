<?php

namespace App\Services\Tenants;

use App\Models\Tenants\Event;
use App\Models\Tenants\Flight;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingForFlightRequested;
use App\Http\Requests\Tenants\StoreBookingRequest;

class BookingService
{
    /**
     * @var PilotService
     */
    protected $pilotService;

    public function __construct()
    {
        $this->pilotService = new PilotService();
    }

    /**
     * Method that handles the BookingController store action
     *
     * @param StoreBookingRequest $request
     * @param Event $event
     * @param Flight $flight
     */
    public function storeBookingRequest(StoreBookingRequest $request, Event $event, Flight $flight)
    {
        $pilot = $this->pilotService->firstOrCreatePilot([
            'vatsim_id' => $request->vatsim_id,
            'email' => $request->email,
        ]);

        $url = $this->getBookingConfirmationUrl($event->slug, $flight->callsign, $pilot->vatsim_id);

        Mail::to($pilot->email)->send(new BookingForFlightRequested($flight, $url));
    }

    /**
     * Determine if given flight is booked for given event
     *
     * @param Event $event
     * @param Flight $flight
     * @return mixed
     */
    public function isFlightBooked(Event $event, Flight $flight)
    {
        return Flight::booked()->where([
            'event_id' => $event->id,
            'callsign' => $flight->callsign,
        ])->exists();
    }

    /**
     * This will generate the confirmation URL for flight booking requests.
     *
     * @param string $slug
     * @param string $callsign
     * @param string $vatsimId
     * @return string
     */
    public function getBookingConfirmationUrl(string $slug, string $callsign, string $vatsimId)
    {
        return route('tenants.events.bookings.store', [
            'slug' => $slug,
            'callsign' => $callsign,
            'vatsimId' => encrypt($vatsimId),
        ]);
    }
}
