<?php

namespace App\Mail\Tenants;

use Illuminate\Mail\Mailable;
use App\Services\TenantService;
use App\Services\Tenants\MailService;

abstract class AbstractTenantMailable extends Mailable
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

    /**
     * @var string
     */
    protected $noReplyFromAddress;

    /**
     * @var string
     */
    protected $noReplyFromName;

    public function __construct()
    {
        $this->tenantService = new TenantService();
        $this->mailService = new MailService();

        $this->tenant = $this->tenantService->getCurrentTenant();

        $this->noReplyFromAddress = $this->mailService->getNoReplyFromAddress($this->tenant);
        $this->noReplyFromName = $this->mailService->getNoReplyFromName($this->tenant);
    }
}
