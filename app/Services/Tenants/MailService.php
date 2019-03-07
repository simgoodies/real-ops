<?php

namespace App\Services\Tenants;

use App\Models\Tenant;
use App\Services\TenantService;

class MailService
{
    protected $tenantService;

    public function __construct()
    {
        $this->tenantService = new TenantService();
    }

    /**
     * Determine the no-reply email address based on given tenant e.g. no-reply-tjzs@ ....
     *
     * @param Tenant|null $tenant
     * @return string
     */
    public function getNoReplyFromAddress(Tenant $tenant = null)
    {
        if ($tenant === null) {
            $tenant = $this->tenantService->getCurrentTenant();
        }

        $identifier = $tenant->identifier;
        $appUrlBase = config('app.url_base');

        return sprintf('no-reply-%s@%s', $identifier, $appUrlBase);
    }

    /**
     * Determine the no-reply name based on given tenant e.g. San Juan CERAP Real Ops.
     *
     * @param Tenant|null $tenant
     * @return string
     */
    public function getNoReplyFromName(Tenant $tenant = null)
    {
        if (is_null($tenant)) {
            $tenant = $this->tenantService->getCurrentTenant();
        }

        $name = $tenant->name;
        return sprintf('%s Real Ops', $name);
    }
}
