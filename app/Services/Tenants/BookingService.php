<?php

namespace App\Services\Tenants;

use Illuminate\Http\Request;
use App\Models\Tenants\Event;
use App\Models\Tenants\Pilot;
use App\Models\Tenants\Flight;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\Tenants\Bookings\BookingConfirmedMailable;
use App\Mail\Tenants\Bookings\BookingRequestedMailable;
use App\Http\Requests\Tenants\Bookings\StoreBookingRequest;
use App\Mail\Tenants\Bookings\CancellationRequestedMailable;
use App\Http\Requests\Tenants\Bookings\StoreCancellationRequest;

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
     * @param Request $request
     * @param Event $event
     * @param Flight $flight
     * @param Pilot $pilot
     * @return bool
     */
    public function storeBooking(Request $request, Event $event, Flight $flight, Pilot $pilot)
    {
        if ($request->hasValidSignature() === false) {
            return redirect()->route('tenants.events.flights.index', ['slug' => $event->slug])
                ->with('failure', 'The booking could not be confirmed due to a missing signature.');
        }

        if ($this->isFlightBooked($flight) === true) {
            return redirect()->route('tenants.events.flights.index', ['slug' => $event->slug])
                ->with('failure',
                    'The flight has already been booked and confirmed by another pilot, try booking another flight.');
        }

        $this->bookFlight($flight, $pilot);

        Mail::to($pilot->email)->send(new BookingConfirmedMailable($event, $flight));
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

        if ($this->isFlightBooked($flight, $event) === true) {
            $failureMessage = sprintf('The flight %s is already booked.', $flight->callsign);
            $request->session()->flash('failure', $failureMessage);
            return;
        }

        $url = $this->getBookingConfirmationUrl($event->slug, $flight->callsign, $pilot->vatsim_id);

        Mail::to($pilot->email)->send(new BookingRequestedMailable($event, $flight, $url));
    }

    public function storeCancellationRequest(StoreCancellationRequest $request, Event $event, Flight $flight)
    {
        $request->session()->flash('success',
            'If the provided e-mail address is correct, you will receive an e-mail to confirm the cancellation request.');
        $pilot = $this->pilotService->getByEmail($request->email);

        if ($pilot === null) {
            return redirect()->route('tenants.events.flights.index', ['slug' => $event->slug]);
        }

        if ($this->isFlightBookedByPilot($flight, $pilot) === false) {
            return redirect()->route('tenants.events.flights.index', ['slug' => $event->slug]);
        }

        $url = $this->getBookingCancellationUrl($event->slug, $flight->callsign, $pilot->vatsim_id);

        Mail::to($pilot->email)->send(new CancellationRequestedMailable($event, $flight, $url));
    }

    /**
     * Book a flight for the given pilot.
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
     * Determine if given flight is booked for given event.
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

    public function isFlightBookedByPilot(Flight $flight, Pilot $pilot, Event $event = null)
    {
        if ($event === null) {
            $event = $flight->event;
        }

        return Flight::booked()->where([
            'event_id' => $event->id,
            'pilot_id' => $pilot->id,
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
        return URL::signedRoute('tenants.events.flights.bookings.store', [
            'slug' => $slug,
            'callsign' => $callsign,
            'vatsimId' => $vatsimId,
        ]);
    }

    /**
     * This will generate the cancellation URL for flight booking requests.
     * 
     * @param string $slug
     * @param string $callsign
     * @param string $vatsimId
     * @return string
     */
    public function getBookingCancellationUrl(string $slug, string $callsign, string $vatsimId)
    {
        return URL::signedRoute('tenants.events.flights.bookings.destroy', [
            'slug' => $slug,
            'callsign' => $callsign,
            'vatsimId' => $vatsimId,
        ]);
    }
}
