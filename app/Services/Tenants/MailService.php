<?php

namespace App\Services\Tenants;


use App\Models\Tenant;
use App\Services\TenantService;
use Hyn\Tenancy\Environment;

class MailService
{
    protected $tenantService;

    public function __construct()
    {
        $this->tenantService = new TenantService();
    }

    public function getFromAddress(Tenant $tenant = null)
    {
        if ($tenant === null) {
            $tenant = $this->tenantService->getCurrentTenant();
        }

        $identifier = $tenant->identifier;
        $appUrlBase = config('app.url_base');

        return sprintf('no-reply-%s@%s', $identifier, $appUrlBase);
    }

    public function getFromName(Tenant $tenant = null)
    {
        if (is_null($tenant)) {
            $tenant = $this->tenantService->getCurrentTenant();
        }

        $name = $tenant->name;
        return sprintf('%s Real Ops', $name);
    }
}
