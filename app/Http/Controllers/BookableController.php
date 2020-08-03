<?php

namespace App\Http\Controllers;

use App\Models\Bookable;
use App\Models\Booker;
use Illuminate\Http\Request;

class BookableController extends Controller
{
    public function confirm(Request $request, Booker $booker, Bookable $bookable)
    {
        if (!$request->hasValidSignature()) {
            session()->flash('booking-confirmation-failed', "Something went wrong... Try again.");

            return redirect()->route('events.show', ['event' => $bookable->event]);
        }

        $bookable->bookedBy()->associate($booker);
        $bookable->booked_at = now();
        $bookable->save();

        session()->flash('booking-confirmed', "You're booking is confirmed!");

        return redirect()->route('events.show', ['event' => $bookable->event]);
    }
}
