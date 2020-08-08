<?php

namespace Tests\Feature;

use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SetupEnvironmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_setup_an_environment()
    {
        $this->login();

        $this->post('setup-environment', [
            'name' => 'Foo Environment',
            'subdomain' => 'foo-environment',
        ])->assertRedirect('login-to-environment');

        $this->assertDatabaseHas('tenants', [
            'name' => 'Foo Environment',
        ]);
        $this->assertDatabaseHas('domains', [
            'domain' => 'foo-environment',
        ]);

        $tenant = Tenant::firstWhere('name', 'Foo Environment');

        $this->assertTrue($this->user->teams->contains($tenant));
    }
}
