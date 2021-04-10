<?php

namespace Tests;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Assert;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use AdditionalAssertions;

    protected $tenancy = false;
    protected $tenant;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        Collection::macro('assertEquals', function($collection) {
            $this->zip($collection)->eachSpread(function ($a, $b) {
                if (is_null($a)) {
                    Assert::assertTrue(false);
                } else {
                    Assert::assertTrue($a->is($b));
                }
            });
        });

        if ($this->tenancy) {
            $this->initializeTenancy();
        }
    }

    public function initializeTenancy()
    {
        $this->tenant = Tenant::create([
            'name' => 'Foo Tenant',
        ]);
        $this->tenant->domains()->create([
            'domain' => 'foo',
        ]);
        tenancy()->initialize($this->tenant);

        config(['app.url' => 'http://foo.' . config('app.url_base')]);

        $urlGenerator = url();
        $urlGenerator->forceRootUrl(config('app.url'));

        $this->withServerVariables([
            'SERVER_NAME' => config('app.url_base'),
            'HTTP_HOST' => config('app.url_base'),
        ]);
    }

    public function login()
    {
        $this->user = factory(User::class)->create();

        $this->user->attachTeam($this->tenant);
        $this->user->switchTeam($this->tenant);

        $this->actingAs($this->user);
    }
}
