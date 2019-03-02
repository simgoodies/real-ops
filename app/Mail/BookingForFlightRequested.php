<?php

namespace App\Mail;

use App\Services\Tenants\MailService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

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

    public function __construct()
    {
        parent::__construct();

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
            ->markdown('tenants.email.booking-for-flight-requested');
    }
}
