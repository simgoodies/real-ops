<?php

namespace App\Http\Controllers\Tenants\Office;

use App\Models\Tenants\Role;
use App\Http\Controllers\Controller;
use App\Services\Tenants\UserService;

class StaffManagementController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;
    
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAll();
        
        return view('tenants.office.staff-management.index')->with([
            'users' => $users,
            'roles' => Role::all(),
        ]);
    }
}
