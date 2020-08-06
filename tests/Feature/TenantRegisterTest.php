<?php

namespace Tests\Feature;

use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TenantRegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_register_to_be_a_tenant()
    {
        $this->withoutExceptionHandling();

        $this->post('register', [
            'name' => 'New User',
            'subdomain' => 'new-user',
        ])->assertRedirect('http://new-user.'.config('app.url_base').'/office');

        $this->assertDatabaseHas('tenants', [
            'name' => 'New User',
        ]);

        $newUserTenant = Tenant::firstWhere('name', 'New User');

        $this->assertDatabaseHas('domains', [
            'tenant_id' => $newUserTenant->id,
            'domain' => 'new-user',
        ]);
    }
}
