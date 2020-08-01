<?php

namespace App\Http\Livewire;

use App\Mail\BookingRequestedMailable;
use App\Models\Bookable;
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

        if ($bookable->isBooked()) {
            $this->render();
            return;
        }

        if (!$booker = Booker::firstWhere('email', $this->email)) {
           $booker = new Booker([
               'email' => $this->email,
           ]);
           $booker->save();
        }

        Mail::to($this->email)->send(new BookingRequestedMailable($booker, $bookable));

        $this->reset(['email']);

        session()->flash('booking-requested', "Booking requested! Check your e-mail to confirm!");

        $this->render();
    }

    public function render()
    {
        $this->bookables = Bookable::all();
        return view('livewire.display-bookables');
    }
}
