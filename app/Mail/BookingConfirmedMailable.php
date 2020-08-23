<?php

namespace App\Mail;

use App\Models\Bookable;
use App\Models\BookableFlight;
use App\Models\BookableTimeSlot;
use App\Models\Booker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmedMailable extends Mailable
{
    use Queueable, SerializesModels;

    /** @var Bookable  */
    private $bookable;

    /** @var Booker  */
    private $booker;

    public function __construct(Booker $booker, Bookable $bookable)
    {
        $this->booker = $booker;
        $this->bookable = $bookable;
        $this->bookable->loadMissing('event');

        $this->populateMail();
    }

    private function populateMail()
    {
        $fromEmail = 'info@' . config('app.url_base');
        $this->from($fromEmail, $this->bookable->event->title);
        $this->subject('Your booking was confirmed!');

        if ($this->bookable instanceof BookableFlight) {
            $this->markdown('emails.booking-confirmed-flight');
        }

        if ($this->bookable instanceof BookableTimeSlot) {
            $this->markdown('emails.booking-confirmed-time-slot');
        }
        $this->with([
            'bookable' => $this->bookable,
            'event' => $this->bookable->event,
        ]);
    }

    public function build()
    {
        return $this;
    }
}
