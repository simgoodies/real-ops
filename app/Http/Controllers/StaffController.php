<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamInviteRequest;
use App\Jobs\AcceptInvitation;
use App\Jobs\InviteStaff;
use Illuminate\Support\Facades\Validator;

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

        AcceptInvitation::dispatchNow($validated['token']);

        return redirect()->route('office.index');
    }
}
