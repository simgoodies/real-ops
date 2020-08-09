<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmedMailable;
use App\Models\Bookable;
use App\Models\Booker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookableController extends Controller
{
    public function confirm(Request $request, Booker $booker, Bookable $bookable)
    {
        if (!$request->hasValidSignature()) {
            session()->flash('booking-confirmation-failed', "Something went wrong... Try again.");

            return redirect()->route('events.show', ['event' => $bookable->event]);
        }

        if ($bookable->isBooked() && !$bookable->bookedBy->is($booker)) {
            session()->flash('booking-confirmation-failed', "This booking was confirmed by someone else! Try an alternative.");

            return redirect()->route('events.show', ['event' => $bookable->event]);
        }

        $bookable->bookedBy()->associate($booker);
        $bookable->booked_at = now();
        $bookable->save();

        Mail::to($booker->email)->send(new BookingConfirmedMailable($booker, $bookable));

        session()->flash('booking-confirmed', "You're booking is confirmed! Check your e-mail for details.");

        return redirect()->route('events.show', ['event' => $bookable->event]);
    }
}
