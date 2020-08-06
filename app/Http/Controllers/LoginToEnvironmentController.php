<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stancl\Tenancy\Database\Models\Domain;

class LoginToEnvironmentController extends Controller
{
    public function index()
    {
        $domains = Domain::whereIn('tenant_id', Auth::user()->teams->pluck('id'))->get();

        return view('login-to-environment.index', [
            'domains' => $domains,
        ]);
    }

    public function store(Request $request)
    {
        $redirectUrl = '/office';

        $subdomain = $request->subdomain;
        $tenant = Domain::firstWhere('domain', $subdomain)->tenant;

        $token = tenancy()->impersonate($tenant, Auth::id(), $redirectUrl, 'web');

        $tenantLoginUserUrl = sprintf('%s://%s.%s/login-user/%s', $request->getScheme(), $subdomain, config('app.url_base'), $token->token);

        return redirect($tenantLoginUserUrl);
    }
}
