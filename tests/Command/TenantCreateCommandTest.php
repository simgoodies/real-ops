<?php

namespace Tests\Command;

use App\Models\Tenant;
use Tests\TenantTestCase;
use App\Models\Tenants\User;
use App\Services\Command\TenantCommandService;

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

    public function testItCannotCreateAnAlreadyExistingTenant()
    {
        $this->artisan('tenant:create',
            ['identifier' => 'tjzs', 'name' => 'San Juan CERAP', 'email' => 'tjzs@example.com']);
        $this->artisan('tenant:create',
            ['identifier' => 'tjzs', 'name' => 'San Juan CERAP', 'email' => 'tjzs@example.com']);
        $this->assertCount(1, Tenant::all());
    }

    public function testItCannotCreateATenantWithWrongArguments()
    {
        $this->artisan('tenant:create',
        ['identifier' => 'toomanycharacters', 'name' => 'San Juan CERAP', 'email' => 'not-an-email.com']);
        $this->assertCount(0, $this->tenantCommandService->getAll());
    }

    public function testTenantHasAdmin()
    {
        $this->artisan('tenant:create',
            ['identifier' => 'tjzs', 'name' => 'San Juan CERAP', 'email' => 'tjzs@example.com']);
        $this->assertDatabaseHas('users', ['email' => 'tjzs@example.com']);
    }

    public function testAdminHasProperRole()
    {
        $this->artisan('tenant:create',
            ['identifier' => 'tjzs', 'name' => 'San Juan CERAP', 'email' => 'tjzs@example.com']
        );

        $user = User::where('email', 'tjzs@example.com')->firstOrFail();

        $this->assertTrue($user->hasRole('admin'));
    }
}
