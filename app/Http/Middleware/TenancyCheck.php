<?php

namespace App\Http\Middleware;

use Closure;
use HipsterJazzbo\Landlord\Facades\Landlord;
use Illuminate\Support\Facades\App;

class TenancyCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws \HipsterJazzbo\Landlord\Facades\TenantNullIdException
     */
    public function handle($request, Closure $next)
    {
        if (App::environment() == 'local') {
            Landlord::addTenant('tenant_id', 1);
        }

        return $next($request);
    }
}
