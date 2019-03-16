<?php

namespace App\Mail\Tenants;

use App\Models\Tenants\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class NewUserInvitationMailable extends AbstractTenantMailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $url;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();

        $this->user = $user;
        $this->url = route('tenants.auth.password.request');

        $this->populateMail();
    }

    private function populateMail()
    {
        $this->from($this->noReplyFromAddress, $this->noReplyFromName);
        $this->subject(sprintf('You have been invited to be staff for %s Real Ops', $this->tenant->name));
        $this->markdown('tenants.email.new-user-invitation');
        $this->with([
            'tenantName' => $this->tenant->name,
            'user' => $this->user,
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
