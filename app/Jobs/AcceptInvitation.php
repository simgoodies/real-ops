<?php

namespace App\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Mpociot\Teamwork\Facades\Teamwork;
use Illuminate\Support\Facades\Session;

class AcceptInvitation
{
    use Dispatchable;

    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function handle()
    {
        $teamInvite = Teamwork::getInviteFromAcceptToken($this->token);

        if (auth()->user()) {
            Teamwork::acceptInvite($teamInvite);
            Session::flash('success', 'You have successfully joined ' . tenant('name'));
        }
    }
}
