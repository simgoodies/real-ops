<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use App\Models\Tenants\Flight;
use Illuminate\Queue\SerializesModels;

class BookingForFlightRequested extends TenantMailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    private $fromAddress;

    /**
     * @var string
     */
    private $fromName;

    /**
     * @var Flight
     */
    private $flight;

    public function __construct(Flight $flight)
    {
        parent::__construct();

        $this->flight = $flight;
        $this->fromAddress = $this->mailService->getFromAddress($this->tenant);
        $this->fromName = $this->mailService->getFromName($this->tenant);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->fromAddress, $this->fromName)
            ->subject('Confirm your requested flight booking')
            ->markdown('tenants.email.booking.requested')
            ->with([
                'tenantName' => $this->tenant->name,
                'flight' => $this->flight,
            ]);
    }
}
