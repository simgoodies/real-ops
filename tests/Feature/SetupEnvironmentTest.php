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
            'owner_id' => $this->user->id,
        ]);
        $this->assertDatabaseHas('domains', [
            'domain' => 'foo-environment',
        ]);

        $tenant = Tenant::firstWhere('name', 'Foo Environment');

        $this->assertTrue($this->user->teams->contains($tenant));
    }

    /** @test */
    public function it_automatically_lowercases_subdomains()
    {
        $this->login();

        $this->post('setup-environment', [
            'name' => 'Foo Environment',
            'subdomain' => 'FOOBAR',
        ])->assertRedirect('login-to-environment');

        $this->assertDatabaseHas('domains', [
            'domain' => 'foobar',
        ]);
    }

    /** @test */
    public function it_will_not_allow_non_unique_subdomains()
    {
        $this->login();

        $this->post('setup-environment', [
            'name' => 'Foo Environment',
            'subdomain' => 'foobar',
        ])->assertRedirect('login-to-environment');

        $this->post('setup-environment', [
            'name' => 'Foo Environment Two',
            'subdomain' => 'foobar',
        ])->assertSessionHasErrors('subdomain');

        $this->assertDatabaseHas('tenants', [
            'name' => 'Foo Environment',
        ]);

        $this->assertDatabaseMissing('tenants', [
            'name' => 'Foo Environment Two',
        ]);
    }
}
