<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use LVR\Subdomain\Subdomain;

class SetupEnvironmentController extends Controller
{
    public function show()
    {
        return view('setup-environment.show');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:255'],
            'subdomain' => ['required', new Subdomain, 'unique:domains,domain']
        ]);

        $tenant = Tenant::create([
            'name' => $validated['name'],
            'owner_id' => Auth::id(),
        ]);

        $tenant->domains()->create([
            'domain' => Str::lower($validated['subdomain']),
        ]);

        Auth::user()->attachTeam($tenant);

        return redirect()->route('login-to-environment.index');
    }
}
