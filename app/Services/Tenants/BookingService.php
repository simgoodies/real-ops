<?php

namespace App\Services\Tenants;

use App\Models\Tenants\Event;
use App\Models\Tenants\Pilot;
use App\Models\Tenants\Flight;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\Tenants\Bookings\ConfirmedMailable;
use App\Mail\Tenants\Bookings\RequestedMailable;
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
     * Method that handles the BookingController store action.
     * 
     * @param Event $event
     * @param Flight $flight
     * @param Pilot $pilot
     * @return bool
     */
    public function storeBooking(Event $event, Flight $flight, Pilot $pilot)
    {
        if ($this->isFlightBooked($flight) == true) {
            return false;
        }
        
        $this->bookFlight($flight, $pilot);
        
        Mail::to($pilot->email)->send(new ConfirmedMailable($event, $flight));
    }
    
    /**
     * Method that handles the BookingRequestController store action.
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

        Mail::to($pilot->email)->send(new RequestedMailable($flight, $url));
    }

    /**
     * Book a flight for the given pilot
     * 
     * @param Flight $flight
     * @param Pilot $pilot
     */
    public function bookFlight(Flight $flight, Pilot $pilot)
    {
        $flight->bookedBy()->associate($pilot);
        $flight->save();
    }

    /**
     * Determine if given flight is booked for given event
     *
     * @param Event $event
     * @param Flight $flight
     * @return mixed
     */
    public function isFlightBooked(Flight $flight, Event $event = null)
    {
        if ($event === null) {
            $event = $flight->event;
        }
        
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
        return URL::signedRoute('tenants.events.bookings.store', [
            'slug' => $slug,
            'callsign' => $callsign,
            'vatsimId' => $vatsimId,
        ]);
    }
}
