<?php

namespace App\Http\Controllers\Tenants\Office;

use App\Http\Controllers\Controller;
use App\Services\Tenants\StaffManagementService;
use App\Http\Requests\Tenants\StaffManagement\StoreStaffManagementUser;

class StaffManagementUserController extends Controller
{
    /**
     * @var StaffManagementService
     */
    protected $staffManagementService;
    
    public function __construct(StaffManagementService $staffManagementService)
    {
        $this->staffManagementService = $staffManagementService;
    }

    public function store(StoreStaffManagementUser $request)
    {
        $this->staffManagementService->storeStaffManagementUser($request);
        
        return redirect()->route('tenants.office.staff-management.index');
    }
}
