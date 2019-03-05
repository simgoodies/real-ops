<?php

namespace App\Mail\Tenants\Bookings;

use Illuminate\Bus\Queueable;
use App\Models\Tenants\Flight;
use Illuminate\Queue\SerializesModels;
use App\Mail\Tenants\AbstractTenantMailable;

class RequestedMailable extends AbstractTenantMailable
{
    use Queueable, SerializesModels;

    /**
     * @var Flight
     */
    private $flight;

    /**
     * This will contain the url to confirm the booking that was requested
     *
     * @var string
     */
    private $url;

    public function __construct(Flight $flight, string $url)
    {
        parent::__construct();

        $this->flight = $flight;
        $this->url = $url;

        $this->populateMail();
    }

    private function populateMail()
    {
        $this->from($this->noReplyFromAddress, $this->noReplyFromName);
        $this->subject(sprintf('Confirm your requested flight %s', $this->flight->callsign));
        $this->markdown('tenants.email.booking.requested');
        $this->with([
            'tenantName' => $this->tenant->name,
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
