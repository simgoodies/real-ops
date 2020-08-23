<?php

namespace App\Http\Livewire;

use App\Mail\BookingRequestedMailable;
use App\Models\Bookable;
use App\Models\BookableFlight;
use App\Models\BookableTimeSlot;
use App\Models\Booker;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class DisplayBookables extends Component
{
    public $event = null;
    public $bookables = null;
    public $email = null;

    public function mount(Event $event) {
        $this->event = $event;
        $this->bookables = [];
    }

    public function bookBookable($bookableId)
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        $bookable = Bookable::find($bookableId);

        if ($bookable->type == BookableFlight::TYPE && $bookable->isBooked()) {
            $this->render();

            return;
        }

        if ($bookable->type == BookableTimeSlot::TYPE && !$bookable->getNextAvailableBooking()) {
            $this->render();

            return;
        }

        if (!$booker = Booker::firstWhere('email', $this->email)) {
           $booker = new Booker([
               'email' => $this->email,
           ]);
           $booker->save();
        }

        if ($bookable->type == BookableTimeSlot::TYPE && $this->event->hasBookingFor($booker)) {
            session()->flash('booking-requested-failed', "You already have a booking for this event!");
            $this->render();

            return;
        }

        Mail::to($this->email)->send(new BookingRequestedMailable($booker, $bookable));

        $this->reset(['email']);

        session()->flash('booking-requested', "Booking requested! Check your e-mail to confirm!");

        $this->render();
    }

    public function render()
    {
        if ($this->event->bookable_type == BookableTimeSlot::TYPE) {
            $this->bookables = BookableTimeSlot::where('event_id', $this->event->id)->groupBy(
                'begin_date',
                'begin_time',
                'data->assignation',
                'data->direction'
            )->get();

            return view('livewire.display-bookables');
        }

        $this->bookables = Bookable::where('event_id', $this->event->id)->get();
        return view('livewire.display-bookables');
    }
}
