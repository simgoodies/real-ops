<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
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
        ]);

        $tenant->domains()->create([
            'domain' => $validated['subdomain']
        ]);

        return redirect()->route('login-to-environment.index');
    }
}
