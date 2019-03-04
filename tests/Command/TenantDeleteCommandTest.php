<?php
namespace Tests\Command;

use Tests\TenantTestCase;
use Illuminate\Database\QueryException;
use App\Services\Command\TenantCommandService;

class TenantDeleteCommandTest extends TenantTestCase
{
    /** @var TenantCommandService $tenantCommandService */
    protected $tenantCommandService;

    protected function setUp()
    {
        parent::setUp();
        $this->tenantCommandService = new TenantCommandService();
    }

    public function testTenantNameIsRequired()
    {
        $this->expectExceptionMessage('Not enough arguments (missing: "identifier").');
        $this->artisan('tenant:delete');
    }

    public function testCanDeleteExistingTenant()
    {
        $this->artisan('tenant:create', ['identifier' => 'tjzs', 'name' => 'San Juan CERAP', 'email' => 'tjzs@example.com']);
        $this->artisan('tenant:delete', ['identifier' => 'tjzs']);
        $this->assertSystemDatabaseMissing('tenants', ['email' => 'tjzs@example.com']);
    }

    public function testItCannotDeleteANonExistingTenant()
    {
        $this->assertCount(0, $this->tenantCommandService->getAll());
        $this->artisan('tenant:delete', ['identifier' => 'tjzs']);
        $this->assertCount(0, $this->tenantCommandService->getAll());
    }

    public function testTenantDatabaseIsRemoved()
    {
        $this->artisan('tenant:create', ['identifier' => 'tjzs', 'name' => 'tjzs', 'email' => 'tjzs@example.com']);
        $this->artisan('tenant:delete', ['identifier' => 'tjzs']);
        $this->expectException(QueryException::class);
        $this->assertDatabaseHas('users', ['email' => 'tjzs@example.com']);
    }
}
