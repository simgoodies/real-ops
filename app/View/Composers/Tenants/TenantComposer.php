<?php

namespace App\Http\View\Composers\Tenants;

use Illuminate\View\View;
use App\Services\TenantService;

class TenantComposer
{
    protected $tenantService;

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('tenant', $this->getTenant());
    }

    private function getTenant()
    {
        return $this->tenantService->getCurrentTenant();
    }
}
