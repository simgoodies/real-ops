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
        $roleStaff = Role::create(['name' => 'staff']);

        // Create permissions
        $permissionAccessOffice = Permission::create(['name' => 'access-office']);
        $permissionAccessStaffManagement = Permission::create(['name' => 'access-staff-management']);

        // Assign roles with their respective permissions
        $roleStaff->givePermissionTo(
            $permissionAccessOffice
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
