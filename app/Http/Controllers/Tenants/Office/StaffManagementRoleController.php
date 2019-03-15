<?php

namespace App\Http\Controllers\Tenants\Office;

use App\Http\Controllers\Controller;
use App\Services\Tenants\StaffManagementService;
use App\Http\Requests\Tenants\StaffManagement\StoreStaffManagementRole;
use App\Http\Requests\Tenants\StaffManagement\DestroyStaffManagementRole;

class StaffManagementRoleController extends Controller
{
    /**
     * @var StaffManagementService
     */
    protected $staffManagementService;
    
    public function __construct(StaffManagementService $staffManagementService)
    {
        $this->staffManagementService = $staffManagementService;
    }

    public function store(StoreStaffManagementRole $request)
    {
        $this->staffManagementService->storeStaffManagementRole($request);
        
        return redirect()->route('tenants.office.staff-management.index');
    }

    public function destroy(DestroyStaffManagementRole $request)
    {
        $this->staffManagementService->destroyStaffManagementRole($request);

        return redirect()->route('tenants.office.staff-management.index');
    }
}
