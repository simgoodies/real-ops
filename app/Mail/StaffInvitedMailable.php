<?php

namespace App\Mail;

use App\Models\TeamInvite;
use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class StaffInvitedMailable extends Mailable
{
    use Queueable, SerializesModels;

    private Tenant $tenant;
    private TeamInvite $invitation;

    public function __construct(Tenant $tenant, TeamInvite $invitation)
    {
        $this->tenant = $tenant;
        $this->invitation = $invitation;

        $this->populateMail();
    }

    private function populateMail()
    {
    $fromEmail = 'info@' . config('app.url_base');
        $this->from($fromEmail, config('mail.from.name'));

        $subject = sprintf('Invitation staff member (%s)', $this->tenant->name);
        $this->subject($subject);

        $this->markdown('emails.staff-invited');

        $this->with([
            'tenant' => $this->tenant,
            'acceptUrl' => $this->acceptUrl(),
        ]);
    }

    private function acceptUrl() {
        return URL::route('staff-accept-invitation.store', ['token' => $this->invitation->accept_token]);
    }

    public function build()
    {
        return $this;
    }
}
