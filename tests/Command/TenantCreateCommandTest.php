<?php

namespace Tests\Command;

use App\Models\User;
use App\Services\Command\TenantCommandService;
use Tests\TenantTestCase;

class TenantCreateCommandTest extends TenantTestCase
{
    /** @var TenantCommandService $tenantCommandService */
    protected $tenantCommandService;

    protected function setUp()
    {
        parent::setUp();
        $this->tenantCommandService = new TenantCommandService();
    }

    public function testTenantIdentifierIsRequired()
    {
        $this->expectExceptionMessage('Not enough arguments (missing: "identifier").');
        $this->artisan('tenant:create', ['name' => 'San Juan CERAP', 'email' => 'tjzs@example.com']);
    }

    public function testTenantNameIsRequired()
    {
        $this->expectExceptionMessage('Not enough arguments (missing: "name").');
        $this->artisan('tenant:create', ['identifier' => 'tjzs', 'email' => 'tjzs@example.com']);
    }

    public function testTenantEmailIsRequired()
    {
        $this->expectExceptionMessage('Not enough arguments (missing: "email").');
        $this->artisan('tenant:create', ['identifier' => 'tjzs', 'name' => 'example']);
    }

    public function testCanCreateNewTenant()
    {
        $this->artisan('tenant:create',
            ['identifier' => 'tjzs', 'name' => 'San Juan CERAP', 'email' => 'tjzs@example.com']);
        $this->assertSystemDatabaseHas('tenants',
            ['identifier' => 'tjzs', 'name' => 'San Juan CERAP', 'email' => 'tjzs@example.com']);
    }

    public function testTenantHasAdmin()
    {
        $this->artisan('tenant:create',
            ['identifier' => 'tjzs', 'name' => 'San Juan CERAP', 'email' => 'tjzs@example.com']);
        $this->assertDatabaseHas('users', ['email' => 'tjzs@example.com']);
    }

    public function testAdminHasProperRoles()
    {
        $this->artisan('tenant:create',
            ['identifier' => 'tjzs', 'name' => 'San Juan CERAP', 'email' => 'tjzs@example.com']);
        $user = User::where('email', 'tjzs@example.com')->firstOrFail();
        $this->assertTrue($user->hasRole('admin'));
        $this->assertTrue($user->hasPermissionTo('edit user'));
        $this->assertTrue($user->hasPermissionTo('create user'));
        $this->assertTrue($user->hasPermissionTo('delete user'));
    }
}
