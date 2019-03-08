<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Hyn\Tenancy\Contracts\CurrentHostname;
use Hyn\Tenancy\Middleware\HostnameActions as BaseHostnameActions;

class HostnameActions extends BaseHostnameActions
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $hostname = config('tenancy.hostname.auto-identification')
            ? app(CurrentHostname::class)
            : null;

        if ($hostname != null) {
            $this->setAppUrl($request, $hostname);

            if ($hostname->under_maintenance_since) {
                return $this->maintenance($hostname);
            }

            if ($hostname->redirect_to) {
                return $this->redirect($hostname);
            }

            if (!$request->secure() && $hostname->force_https) {
                return $this->secure($hostname, $request);
            }
        } else {
            if (config('tenancy.hostname.fallback-url')) {
                $url = config('tenancy.hostname.fallback-url');
                
                if (strstr(request()->url(), $url) == false) {
                    return redirect()->away($url);
                }
            }
            
            $this->abort($request);
        }

        return $next($request);
    }

    protected function abort(Request $request)
    {
        $url = config('tenancy.hostname.fallback-url');
        
        if (strstr(request()->url(), $url) == false) {
            return redirect()->away($url);
        }
    }
}
