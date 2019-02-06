<?php

namespace App\Http\View\Composers\Tenants;

use App\Services\TenantService;
use Illuminate\View\View;

class OfficeComposer
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
        $view->with('office_title', $this->getOfficeTitle());
    }

    private function getOfficeTitle() {
        return $this->tenantService->getCurrentTenant()->name;
    }
}