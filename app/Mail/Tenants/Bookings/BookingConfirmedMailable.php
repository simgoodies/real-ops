<?php

namespace App\Mail\Tenants\Bookings;

use App\Models\Tenants\Event;
use Illuminate\Bus\Queueable;
use App\Models\Tenants\Flight;
use Illuminate\Queue\SerializesModels;
use App\Mail\Tenants\AbstractTenantMailable;

class BookingConfirmedMailable extends AbstractTenantMailable
{
    use Queueable, SerializesModels;

    /**
     * @var Flight
     */
    protected $flight;

    /**
     * @var Event
     */
    protected $event;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Event $event, Flight $flight)
    {
        parent::__construct();

        $this->event = $event;
        $this->flight = $flight;

        $this->populateMail();
    }

    private function populateMail()
    {
        $this->from($this->noReplyFromAddress, $this->noReplyFromName);
        $this->subject(sprintf('You are booked for flight %s', $this->flight->callsign));
        $this->markdown('tenants.email.bookings.booking-confirmed');
        $this->with([
            'tenantName' => $this->tenant->name,
            'event' => $this->event,
            'flight' => $this->flight,
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
