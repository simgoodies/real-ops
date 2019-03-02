<?php

namespace App\Mail;

use App\Services\Tenants\MailService;
use App\Services\TenantService;
use Illuminate\Mail\Mailable;

class TenantMailable extends Mailable
{
    /**
     * @var TenantService
     */
    protected $tenantService;

    /**
     * @var MailService
     */
    protected $mailService;

    /**
     * @var \App\Models\Tenant
     */
    protected $tenant;

    public function __construct()
    {
        $this->tenantService = new TenantService();
        $this->mailService = new MailService();

        $this->tenant = $this->tenantService->getCurrentTenant();
    }
}
