<?php

namespace App\Http\Controllers;

use App\Models\Bookable;
use App\Models\Booker;

class BookableController extends Controller
{
    public function confirm(Booker $booker, Bookable $bookable)
    {
        $bookable->booked_by()->associate($booker);
        $bookable->booked_at = now();
        $bookable->save();

        session()->flash('booking-confirmed', "You're booking is confirmed!");

        return redirect()->route('events.show', ['slug' => $bookable->event]);
    }
}
