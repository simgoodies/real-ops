<?php

namespace Tests\Feature\Tenant\Office;

use Tests\TenantTestCase;
use App\Models\Tenants\Role;
use App\Models\Tenants\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Services\Tenants\UserService;
use App\Mail\Tenants\NewUserInvitationMailable;

class StaffManagementTest extends TenantTestCase
{
    /**
     * @var UserService
     */
    protected $userService;
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->userService = $this->app->make(UserService::class);
    }

    public function testItCanAssignARole()
    {
        $this->setUpAndActivateTenant();
        $this->loggedInAdminUser();
        
        $userToGetStaffRole = factory(User::class)->create(['name' => 'John']);
        
        $staffRole = Role::where('name', 'staff')->first();
        
        $response = $this->post('office/staff-management/assign-role', [
            'role_id' => $staffRole->id,
            'user_id' => $userToGetStaffRole->id,
        ]);
        
        $response->assertRedirect('office/staff-management');
        $response->assertSessionHas('success', "The role 'staff' has successfully been assigned to John");
        $this->assertTrue($userToGetStaffRole->hasRole('staff'));
    }
    
    public function testItCanRemoveARole()
    {
        $this->setUpAndActivateTenant();
        $this->loggedInAdminUser();

        $staffRole = Role::where('name', 'staff')->first();
        $userWithRole = factory(User::class)->create(['name' => 'John']);
        $userWithRole->assignRole($staffRole);


        $response = $this->delete('office/staff-management/remove-role', [
            'role_id' => $staffRole->id,
            'user_id' => $userWithRole->id,
        ]);
        
        $userWithRole = $userWithRole->fresh();

        $response->assertRedirect('office/staff-management');
        $response->assertSessionHas('success', "The role 'staff' has been successfully removed from John");
        $this->assertFalse($userWithRole->hasRole('staff'));
    }
    
    public function testItCanInviteANewUser()
    {
        $this->setUpAndActivateTenant();
        $this->loggedInAdminUser();
        Mail::fake();
        
        $response = $this->post('office/staff-management/create-user', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);
            
        Mail::assertSent(NewUserInvitationMailable::class, function ($mail) {
            $this->assertEquals('You have been invited to be staff for San Juan CERAP Real Ops', $mail->subject);
            $this->assertEquals('johndoe@example.com', $mail->to[0]['address']);
            $this->assertEquals('no-reply-tjzs@realops.test', $mail->from[0]['address']);
            $this->assertEquals('San Juan CERAP Real Ops', $mail->from[0]['name']);
            return true;
        });
        
        $response->assertRedirect('office/staff-management');
        $response->assertSessionHas('success', 'You have invited John Doe to be a staff member.');
    }
    
    public function testItCannotInviteAnExistingUser()
    {
        $this->setUpAndActivateTenant();
        $this->loggedInAdminUser();
        Mail::fake();
        
        factory(User::class)->create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);

        $response = $this->post('office/staff-management/create-user', [
            'name' => 'John Doe Again',
            'email' => 'johndoe@example.com'
        ]);
        
        Mail::assertNothingSent();

        $response->assertRedirect('office/staff-management');
        $response->assertSessionHas('failure', 'This user already exists as a staff member.');
        $this->assertEquals('John Doe', $this->userService->getByEmail('johndoe@example.com')->name);
    }
    
    public function testItCannotRemoveItsOwnAdminRole()
    {
        $this->setUpAndActivateTenant();
        $this->loggedInAdminUser();

        $adminRole = Role::where('name', 'admin')->first();
        $loggedInAdminUser = Auth::user();
        
        $response = $this->delete('office/staff-management/remove-role', [
            'role_id' => $adminRole->id,
            'user_id' => $loggedInAdminUser->id,
        ]);

        $loggedInAdminUser = $loggedInAdminUser->fresh();
        
        $response->assertRedirect('office/staff-management');
        $response->assertSessionHas('failure', "You cannot remove your own 'admin' role.");
        $this->assertTrue($loggedInAdminUser->hasRole('admin'));
    }
}
