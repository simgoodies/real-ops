<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffInvitationRequest;
use App\Mail\StaffInvitedMailable;
use App\Models\TeamInvite;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Mpociot\Teamwork\Facades\Teamwork;

class StaffController extends Controller
{
    public function index()
    {
        return view('staff.index');
    }

    public function invite(StaffInvitationRequest $request) {
        $emailInvitee = $request->input('email');

        if (tenant()->users()->where('email', $emailInvitee)->exists()) {
            Session::flash('failure', $emailInvitee . ' is already member of this team.');

            return redirect()->route('staff.index');
        };

        if (TeamInvite::where('team_id', tenant('id'))->where('email', $emailInvitee)->where('created_at', '>', now()->subDay())->exists()) {
            Session::flash('failure', $emailInvitee . ' has recently already been invited.');

            return redirect()->route('staff.index');
        }

        TeamInvite::where('team_id', tenant('id'))->where('email', $emailInvitee)->delete();

        Mail::to($emailInvitee)->send(new StaffInvitedMailable(tenant()));
        Teamwork::inviteToTeam($emailInvitee);

        Session::flash('success', $emailInvitee . ' has successfully been invited.');

        return redirect()->route('staff.index');
    }
}
