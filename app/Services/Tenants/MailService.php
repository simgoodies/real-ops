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
    public function getNoReplyFromAddress()
    {
        $appUrlBase = config('app.url_base');

        return sprintf('app@%s', $appUrlBase);
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
