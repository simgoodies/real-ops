<?php

namespace App\Services\Tenants;

use App\Models\Tenants\Event;
use App\Models\Tenants\Flight;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingForFlightRequested;
use App\Http\Requests\Tenants\StoreBooking;

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
     * @param StoreBooking $request
     * @param Flight $flight
     */
    public function storeBooking(StoreBooking $request, Flight $flight)
    {
        $pilot = $this->pilotService->firstOrCreatePilot([
            'vatsim_id' => $request->vatsim_id,
            'email' => $request->email,
        ]);

        $flight->bookedBy()->associate($pilot);

        Mail::to($pilot->email)->send(new BookingForFlightRequested($flight->fresh()));

        $flight->save();
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
}
