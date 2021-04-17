<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamInviteRequest;
use App\Jobs\AcceptInvitation;
use App\Jobs\InviteStaff;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mpociot\Teamwork\Facades\Teamwork;

class StaffController extends Controller
{
    public function index()
    {
        return view('staff.index', [
            'staff' => tenant()->users,
        ]);
    }

    public function invite(StoreTeamInviteRequest $request) {
        $emailInvitee = $request->input('email');

        InviteStaff::dispatchNow($emailInvitee);

        return redirect()->route('staff.index');
    }

    public function acceptInvitation(string $token) {
        $validated = Validator::validate(['token' => $token], [
            'token' => 'required|alpha_num',
        ]);

        if (! $teamInvite = Teamwork::getInviteFromAcceptToken($validated['token'])) {
            return redirect()->route('login', ['info' => 'This invitation has already been used and/or is no longer valid!']);
        }

        if (! $invitedUser = User::where('email', $teamInvite->email)->first()) {
            return redirect()->route('register', ['info' => 'Please create an account and try accepting the invitation again!']);
        };

        $invitedUser->attachTeam($teamInvite->team);
        $teamInvite->delete();

        return redirect()->route('login', ['info' => 'You have successfully joined ' . $teamInvite->team->name]);
    }
}
