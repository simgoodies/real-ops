<?php

namespace App\Mail\Tenants\Bookings;

use App\Models\Tenants\Event;
use Illuminate\Bus\Queueable;
use App\Models\Tenants\Flight;
use Illuminate\Queue\SerializesModels;
use App\Mail\Tenants\AbstractTenantMailable;

class CancellationRequestedMailable extends AbstractTenantMailable
{
    use Queueable, SerializesModels;

    /**
     * @var Flight
     */
    private $flight;

    /**
     * @var Event 
     */
    private $event;

    /**
     * This will contain the url to confirm the cancellation of the booking that was requested
     *
     * @var string
     */
    private $url;

    public function __construct(Event $event, Flight $flight, string $url)
    {
        parent::__construct();

        $this->event = $event;
        $this->flight = $flight;
        $this->url = $url;

        $this->populateMail();
    }

    private function populateMail()
    {
        $this->from($this->noReplyFromAddress, $this->noReplyFromName);
        $this->subject(sprintf('Confirm your cancellation for flight %s', $this->flight->callsign));
        $this->markdown('tenants.email.bookings.cancellation-requested');
        $this->with([
            'tenantName' => $this->tenant->name,
            'event' => $this->event,
            'flight' => $this->flight,
            'url' => $this->url,
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
