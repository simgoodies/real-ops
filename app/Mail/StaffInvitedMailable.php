<?php

namespace App\Mail;

use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StaffInvitedMailable extends Mailable
{
    use Queueable, SerializesModels;

    /** @var Tenant */
    private $tenant;

    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;

        $this->populateMail();
    }



    private function populateMail()
    {
        $fromEmail = 'info@' . config('app.url_base');
        $this->from($fromEmail, config('mail.from.name'));

        $subject = sprintf('Invitation staff member (%s)', $this->tenant->name);
        $this->subject($subject);

        $this->markdown('emails.staff-invited');

        $this->with(['tenant' => $this->tenant]);
    }

    public function build()
    {
        return $this;
    }
}
