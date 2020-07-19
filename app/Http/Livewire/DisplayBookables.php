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
           $booker = (new Booker([
               'email' => $this->email,
           ]))->save();
        }

        $bookable->booked_by()->associate($booker);
        $bookable->booked_at = now();
        $bookable->save();

        Mail::to($this->email)->send(new BookingRequestedMailable($this->event, $bookable));

        $this->render();
    }

    public function render()
    {
        $this->bookables = Bookable::all();
        return view('livewire.display-bookables');
    }
}
