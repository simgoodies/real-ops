<?php

namespace App\Services\Tenants;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Tenants\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\Tenants\NewUserInvitationMailable;
use App\Http\Requests\Tenants\StaffManagement\StoreStaffManagementRole;
use App\Http\Requests\Tenants\StaffManagement\StoreStaffManagementUser;
use App\Http\Requests\Tenants\StaffManagement\DestroyStaffManagementRole;

class StaffManagementService
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var RoleService
     */
    protected $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    /**
     * The method that handles the store function on the StaffManagementRole controller
     *
     * @param StoreStaffManagementRole $request
     * @return bool
     */
    public function storeStaffManagementRole(StoreStaffManagementRole $request)
    {
        $user = $this->userService->getById($request->user_id);
        $role = $this->roleService->getById($request->role_id);

        $user->assignRole($role);

        $successMessage = sprintf("The role '%s' has successfully been assigned to %s", $role->name, $user->name);
        $request->session()->flash('success', $successMessage);
        
        return true;
    }

    /**
     * The method that handles the destroy function on the StaffManagementRole controller
     * 
     * @param DestroyStaffManagementRole $request
     * @return bool
     */
    public function destroyStaffManagementRole(DestroyStaffManagementRole $request)
    {
        $user = $this->userService->getById($request->user_id);
        $role = $this->roleService->getById($request->role_id);

        if (Auth::user()->id == $user->id && $role->name == 'admin') {
            $request->session()->flash('failure', "You cannot remove your own 'admin' role.");
            return false;
        }
        
        $user->removeRole($role);

        $successMessage = sprintf("The role '%s' has been successfully removed from %s", $role->name, $user->name);
        $request->session()->flash('success', $successMessage);
        
        return true;
    }

    /**
     * The method that handles the store function on the StaffManagementUser controller
     * 
     * @param StoreStaffManagementUser $request
     * @return bool
     */
    public function storeStaffManagementUser(StoreStaffManagementUser $request)
    {
        if ($this->userService->existsByEmail($request->email) == true) {
            $request->session()->flash('failure', 'This user already exists as a staff member.');
            return false;
        }
        
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Str::random(32);
        
        $user->save();
        
        Mail::to($user->email)->send(new NewUserInvitationMailable($user));
        
        $successMessage = sprintf('You have invited %s to be a staff member.', $user->name);
        $request->session()->flash('success', $successMessage);
        
        return true;
    }
}
