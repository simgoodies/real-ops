<?php

namespace App\Mail;

use App\Models\Bookable;
use App\Models\Booker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingRequestedMailable extends Mailable
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
        $confirmationUrl = $this->bookable->getConfirmationUrl($this->booker);
        $this->from($fromEmail, $this->bookable->event->title);
        $this->subject('Confirm your requested booking');
        $this->markdown('emails.booking-requested');
        $this->with([
            'event' => $this->bookable->event,
            'confirmationUrl' => $confirmationUrl,
        ]);
    }

    public function build()
    {
        return $this;
    }
}
