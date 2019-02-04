<?php
namespace Tests\Command;

use Illuminate\Database\QueryException;
use Tests\TenantAwareTestCase;

class TenantDeleteCommandTest extends TenantAwareTestCase
{
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

    public function testTenantDatabaseIsRemoved()
    {
        $this->artisan('tenant:create', ['identifier' => 'tjzs', 'name' => 'tjzs', 'email' => 'tjzs@example.com']);
        $this->artisan('tenant:delete', ['identifier' => 'tjzs']);
        $this->expectException(QueryException::class);
        $this->assertDatabaseHas('users', ['email' => 'tjzs@example.com']);
    }
    protected function tearDown()
    {
        $this->deleteTenantIfExists(['identifier' => 'tjzs']);
        parent::tearDown();
    }
}