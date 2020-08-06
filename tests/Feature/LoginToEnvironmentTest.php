<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginToEnvironmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_only_displays_tenant_that_user_is_part_of()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        $tenantOne = Tenant::create(['name' => 'Foo']);
        $domainOne = $tenantOne->domains()->create(['domain' => 'domain1']);

        $tenantTwo = Tenant::create(['name' => 'Bar']);
        $domainTwo = $tenantTwo->domains()->create(['domain' => 'domain2']);

        $user->attachTeam($tenantOne);

        $this->actingAs($user);

        $expectedDomains = collect([$domainOne]);
        $response = $this->get('login-to-environment');

        $expectedDomains->assertEquals($response['domains']);
    }
}
