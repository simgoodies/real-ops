<?php

namespace App\Mail;

use App\Models\Bookable;
use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class BookingRequestedMailable extends Mailable
{
    use Queueable, SerializesModels;

    /** @var Bookable  */
    private $bookable;

    /** @var Event  */
    private $event;

    public function __construct(Event $event, Bookable $bookable)
    {
        $this->event = $event;
        $this->bookable = $bookable;

        $this->populateMail();
    }

    private function populateMail()
    {
        $appUrlBase = config('app.url_base');
        $fromEmail = 'info@' . $appUrlBase;
        $confirmationUrl = URL::signedRoute('bookings.store', [
            'slug' => $this->event->slug,
            'bookingId' => $this->bookable->id,
        ]);

        $this->from($fromEmail, $this->event->title);
        $this->subject('Confirm your requested booking');
        $this->markdown('emails.booking-requested');
        $this->with([
            'event' => $this->event,
            'confirmationUrl' => $confirmationUrl,
        ]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this;
    }
}
