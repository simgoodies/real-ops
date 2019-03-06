<?php

use App\Models\Tenants\Role;
use App\Models\Tenants\Permission;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialRolesAndPermissionsSeed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create roles
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleStaffMember = Role::create(['name' => 'staff-member']);

        // Create permissions
        $permissionAccessOffice = Permission::create(['name' => 'access-office']);
        $permissionsAccessEvents = Permission::create(['name' => 'access-events']);
        $permissionAccessStaffMembers = Permission::create(['name' => 'access-staff-members']);

        // Assign roles with their respective permissions
        $roleStaffMember->givePermissionTo(
            $permissionAccessOffice,
            $permissionsAccessEvents
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            //
        });
    }
}
