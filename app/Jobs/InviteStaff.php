<?php

namespace App\Jobs;

use App\Mail\StaffInvitedMailable;
use App\Models\TeamInvite;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Mpociot\Teamwork\Facades\Teamwork;

class InviteStaff
{
    use Dispatchable;

    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function handle()
    {
        if (tenant()->users()->where('email', $this->email)->exists()) {
            Session::flash('failure', $this->email . ' is already member of this team.');

            return;
        };

        if (TeamInvite::where('team_id', tenant('id'))->where('email', $this->email)->where('created_at', '>', now()->subDay())->exists()) {
            Session::flash('failure', $this->email . ' has recently already been invited.');

            return;
        }

        TeamInvite::where('team_id', tenant('id'))->where('email', $this->email)->delete();

        $invitation = Teamwork::inviteToTeam($this->email);
        Mail::to($this->email)->send(new StaffInvitedMailable(tenant(), $invitation));

        Session::flash('success', $this->email . ' has successfully been invited.');
    }
}
