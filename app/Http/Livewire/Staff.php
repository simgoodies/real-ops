<?php

namespace App\Http\Livewire;

use App\Mail\StaffInvitedMailable;
use App\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Mpociot\Teamwork\Facades\Teamwork;

class Staff extends Component
{
    public $email;

    public function invite()
    {
        $invitedUser = User::firstWhere('email', $this->email);
        $team = tenant();

        Teamwork::inviteToTeam($invitedUser, $team, function () use ($invitedUser) {
            Mail::to($this->email)->send(new StaffInvitedMailable($invitedUser));
        });

    }

    public function render()
    {
        return view('livewire.staff', [
            'members' => tenant()->users,
        ]);
    }
}
